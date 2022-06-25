<?php

namespace Abordage\TotalCard;

use DateInterval;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Laravel\Nova\Card;

class TotalCard extends Card
{
    protected ?string $title = null;
    protected ?string $error = null;
    protected ?Builder $builder;
    protected ?int $total;
    protected ?DateInterval $cacheFor;

    /**
     * @param Model|Builder|string $model
     * @param string|null $title
     * @param mixed $cacheFor
     * @param string|null $component
     */
    public function __construct($model, ?string $title = null, $cacheFor = null, ?string $component = null)
    {
        $this->builder = $this->getBuilder($model);
        $this->cacheFor = $this->getCacheFor($cacheFor);
        $this->total = $this->getTotal();
        $this->title = $title ?? $this->getTitle();

        parent::__construct($component);
    }

    /**
     * @param Model|Builder|string $model
     * @return Builder|null
     */
    private function getBuilder($model): ?Builder
    {
        if ($model instanceof Builder) {
            return $model;
        }

        if (is_string($model)) {
            if (!class_exists($model)) {
                $this->error = 'Model ' . $model . ' not found';

                return null;
            }
            $model = new $model();
        }

        if ($model instanceof Model) {
            return $model->newQuery();
        }

        return null;
    }

    /**
     * @param mixed $cacheFor
     * @return DateInterval|null
     * @throws Exception
     */
    private function getCacheFor($cacheFor): ?DateInterval
    {
        if (is_null($cacheFor)) {
            return null;
        }

        if (is_numeric($cacheFor)) {
            return new DateInterval(sprintf('PT%dS', $cacheFor * 60));
        }

        if ($cacheFor instanceof DateInterval) {
            return $cacheFor;
        }

        return null;
    }

    private function getTotal(): ?int
    {
        if (is_null($this->builder)) {
            return null;
        }

        $cacheKey = 'total_card_' . hash('md4', $this->builder->toSql());
        if ($this->cacheFor instanceof DateInterval) {
            $total = Cache::get($cacheKey);
            if (is_int($total)) {
                return $total;
            }
        }

        try {
            $total = $this->builder->count();
            if (is_int($total) && $this->cacheFor instanceof DateInterval) {
                Cache::put($cacheKey, $total, $this->cacheFor);
            }

            return $total;
        } catch (Exception $e) {
            $this->error = $e->getMessage();
        }

        return null;
    }

    private function getTitle(): ?string
    {
        if (is_null($this->builder)) {
            return null;
        }

        return Str::plural(Str::title(Str::snake(class_basename($this->builder->getModel()->getTable()), ' ')));
    }

    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = '1/3';

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component(): string
    {
        return 'total-card';
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return array_merge([
            'title' => $this->title,
            'error' => $this->error,
            'total' => $this->total,
        ], parent::jsonSerialize());
    }
}
