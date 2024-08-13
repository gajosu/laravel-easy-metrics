<?php

namespace SaKanjo\EasyMetrics\Enums;

use Carbon\CarbonImmutable;

enum Range: string
{
    case TODAY = 'TODAY';
    case YESTERDAY = 'YESTERDAY';
    case WTD = 'WTD';
    case MTD = 'MTD';
    case QTD = 'QTD';
    case YTD = 'YTD';
    case ALL = 'ALL';

    public function getPreviousRange(?string $timezone = null): ?array
    {
        $now = CarbonImmutable::now($timezone);

        return match ($this) {
            Range::TODAY => [
                $now->subDay()->startOfDay(),
                $now->subDay()->endOfDay(),
            ],
            Range::YESTERDAY => [
                $now->subDays(2)->startOfDay(),
                $now->subDays(2)->endOfDay(),
            ],
            Range::WTD => [
                $now->subWeek()->startOfWeek(),
                $now->subWeek()->endOfWeek(),
            ],
            Range::MTD => [
                $now->subMonthWithoutOverflow()->startOfMonth(),
                $now->subMonthWithoutOverflow()->endOfMonth(),
            ],
            Range::QTD => [
                $now->subQuarter()->startOfQuarter(),
                $now->subQuarter()->endOfQuarter(),
            ],
            Range::YTD => [
                $now->subYear()->startOfYear(),
                $now->subYear()->endOfYear(),
            ],
            Range::ALL => null,
        };
    }

    public function getRange(?string $timezone = null): ?array
    {
        $now = CarbonImmutable::now($timezone);

        return match ($this) {
            Range::TODAY => [
                $now->startOfDay(),
                $now,
            ],
            Range::YESTERDAY => [
                $now->subDay()->startOfDay(),
                $now->subDay()->endOfDay(),
            ],
            Range::WTD => [
                $now->startOfWeek(),
                $now,
            ],
            Range::MTD => [
                $now->startOfMonth(),
                $now,
            ],
            Range::QTD => [
                $now->startOfQuarter(),
                $now,
            ],
            Range::YTD => [
                $now->startOfYear(),
                $now,
            ],
            Range::ALL => null,
        };
    }
}
