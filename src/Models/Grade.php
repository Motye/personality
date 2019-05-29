<?php

namespace Personalities\Models;

use Jenssegers\Mongodb\Eloquent\Model as Model;
use App\Models\MedusaConfig;
use App\Models\Rating;

/**
 * TRMN Grade Model.
 *
 * Pay Grades and descriptions
 *
 * @package TRMN/personality
 */
class Grade extends Medusa\Models\Grade
{
    public static function getRequirements($paygrade2check)
    {
        $requirements = MedusaConfig::get('pp.requirements');

        return $requirements[$paygrade2check];
    }

    public static function getRankTitle($grade, $rate = null, $branch = 'RMN')
    {
        $gradeDetails = self::where('grade', '=', $grade)->first();

        $rateDetail = Rating::where('rate_code', '=', $rate)->first();

        if (empty($gradeDetails->rank[$branch]) === false) {
            $rank_title = self::mbTrim($gradeDetails->rank[$branch]);
        } else {
            $rank_title = $grade;
        }

        if (empty($rateDetail->rate[$branch][$grade]) === false) {
            $rank_title = $rateDetail->rate[$branch][$grade];
        }

        return $rank_title;
    }

    /**
     * Shortcut method to get enlisted paygrades.
     *
     * @return array
     */
    public static function enlistedPayGrades()
    {
        return self::filterGrades('E');
    }

    /**
     * Shortcut method to get warrant officer paygrades.
     *
     * @return array
     */
    public static function warrantPayGrades()
    {
        return self::filterGrades('W');
    }

    /**
     * Shortcut method to get officer paygrades.
     *
     * @return array
     */
    public static function officerPayGrades()
    {
        return self::filterGrades('O');
    }

    /**
     * Shortcut method to get flag officer paygrades.
     *
     * @return array
     */
    public static function flagPayGrades()
    {
        return self::filterGrades('F');
    }

    /**
     * Shortcut method to get civilian paygrades.
     *
     * @return array
     */
    public static function civilianPayGrades()
    {
        return self::filterGrades('C');
    }
}
