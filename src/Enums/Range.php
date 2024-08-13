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
                $this->convertToLocalTime($now->subDay()->startOfDay()),
                $this->convertToLocalTime($now->subDay()->endOfDay()),
            ],
            Range::YESTERDAY => [
                $this->convertToLocalTime($now->subDays(2)->startOfDay()),
                $this->convertToLocalTime($now->subDays(2)->endOfDay()),
            ],
            Range::WTD => [
                $this->convertToLocalTime($now->subWeek()->startOfWeek()),
                $this->convertToLocalTime($now->subWeek()->endOfWeek()),
            ],
            Range::MTD => [
                $this->convertToLocalTime($now->subMonthWithoutOverflow()->startOfMonth()),
                $this->convertToLocalTime($now->subMonthWithoutOverflow()->endOfMonth()),
            ],
            Range::QTD => [
                $this->convertToLocalTime($now->subQuarter()->startOfQuarter()),
                $this->convertToLocalTime($now->subQuarter()->endOfQuarter()),
            ],
            Range::YTD => [
                $this->convertToLocalTime($now->subYear()->startOfYear()),
                $this->convertToLocalTime($now->subYear()->endOfYear()),
            ],
            Range::ALL => null,
        };
    }

    public function getRange(?string $timezone = null): ?array
    {
        $now = CarbonImmutable::now($timezone);

        return match ($this) {
            Range::TODAY => [
                $this->convertToLocalTime($now->startOfDay()),
                $this->convertToLocalTime($now),
            ],
            Range::YESTERDAY => [
                $this->convertToLocalTime($now->subDay()->startOfDay()),
                $this->convertToLocalTime($now->subDay()->endOfDay()),
            ],
            Range::WTD => [
                $this->convertToLocalTime($now->startOfWeek()),
                $this->convertToLocalTime($now),
            ],
            Range::MTD => [
                $this->convertToLocalTime($now->startOfMonth()),
                $this->convertToLocalTime($now),
            ],
            Range::QTD => [
                $this->convertToLocalTime($now->startOfQuarter()),
                $this->convertToLocalTime($now),
            ],
            Range::YTD => [
                $this->convertToLocalTime($now->startOfYear()),
                $this->convertToLocalTime($now),
            ],
            Range::ALL => null,
        };
    }

    protected function convertToLocalTime(CarbonImmutable $date): CarbonImmutable
    {
        return $date->setTimezone(CarbonImmutable::now()->getTimezone());
    }
}
