<?php

class SlugHelper
{
    // Generate a Unique Slug
    public static function generateUniqueSlug($name, $model = null)
    {
        // Convert To Lowercase And Replace Non-Alphanumeric Characters With Hyphens
        $slug = preg_replace('/[^a-zA-Z0-9]+/', '-', strtolower($name));

        // Trim Hyphens From The Start And End
        $slug = trim($slug, '-');

        // Replace Multiple Hyphens With A Single Hyphen
        $slug = preg_replace('/-+/', '-', $slug);

        // If a Model Is Provided, Check for Duplicates
        if ($model) {
            $originalSlug = $slug;
            $count = 1;

            // Check the Provided Model For Duplicate Slugs
            while ($model::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
        }

        return $slug;
    }
}
