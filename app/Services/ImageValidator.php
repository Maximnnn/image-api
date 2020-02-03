<?php
/**
 * Created by PhpStorm.
 * User: winwi
 * Date: 1/31/2020
 * Time: 8:40 PM
 */

namespace App\Services;

use App\ImageParameters;
use App\Rectangle;

class ImageValidator
{
    public function validateRectangles(ImageParameters $imageParameters, array $rectangles)
    {
        $this->checkCrosses($rectangles);

        $this->checkBorders($rectangles, $imageParameters);
    }

    private function checkCrosses(array $rectangles)
    {
        foreach ($rectangles as $i => $rectangle1) {
            foreach ($rectangles as $n => $rectangle2) {
                if ($i !== $n) {
                    $this->compareRectangles($rectangle1, $rectangle2);
                }
            }
        }
    }

    private function checkBorders(array $rectangles, ImageParameters $imageParameters)
    {
        foreach ($rectangles as $rectangle) {
            if (
                $rectangle->x + $rectangle->width > $imageParameters->width
                || $rectangle->y + $rectangle->height > $imageParameters->height
            ) {
                throw new ValidateException('rectangles_out_of_bounds', ['rectangles_out_of_bounds' => ['id' => $rectangle->customId]]);
            }
        }
    }

    private function compareRectangles(Rectangle $r1, Rectangle $r2)
    {
        if (
            $r1->left() < $r2->right() && $r1->right() > $r2->left()
            && $r1->top() > $r2->bottom() && $r1->bottom() < $r2->top()
        ) {
            throw new ValidateException('rectangles_overlap', ['rectangles_overlap' => ['ids' => [$r1->customId, $r2->customId]]]);
        }
    }
}
