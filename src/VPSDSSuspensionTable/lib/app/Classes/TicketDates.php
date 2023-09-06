<?php

namespace WHMCS\Module\Addon\VPSDSSuspensionTable\app\Classes;

use \Carbon\Carbon;

class TicketDates
{
    public static function ClientCreatedToNowMonths(string $clientcreationdate)
    {
        $to = Carbon::now();
        $from = Carbon::parse($clientcreationdate);
        return $from->diffInMonths($to);
    }

    public static function AddDaysToDate(string $date, int $days)
    {
        $dateObj = Carbon::parse($date);

        return $dateObj->addDays($days)->toDateString();
    }

    public static function SuspensionTicketDate(string $duedate, string $clientcreationdate, int $isvpsds)
    {
        if (self::ClientCreatedToNowMonths($clientcreationdate) < 12) {
            return $isvpsds ? self::AddDaysToDate($duedate, 2) : self::AddDaysToDate($duedate, 2);
        } elseif (self::ClientCreatedToNowMonths($clientcreationdate) < 24) {
            return self::AddDaysToDate($duedate, 4);
        } else {
            return $isvpsds ? self::AddDaysToDate($duedate, 6) : self::AddDaysToDate($duedate, 4);
        }
    }

    public static function TerminationTicketDate(string $duedate, string $clientcreationdate, int $isvpsds)
    {
        if (self::ClientCreatedToNowMonths($clientcreationdate) < 12) {
            return $isvpsds ? self::AddDaysToDate($duedate, 6) : self::AddDaysToDate($duedate, 5);
        } elseif (self::ClientCreatedToNowMonths($clientcreationdate) < 24) {
            return $isvpsds ? self::AddDaysToDate($duedate, 9) : self::AddDaysToDate($duedate, 6);
        } else {
            return $isvpsds ? self::AddDaysToDate($duedate, 13) : self::AddDaysToDate($duedate, 6);
        }
    }
}