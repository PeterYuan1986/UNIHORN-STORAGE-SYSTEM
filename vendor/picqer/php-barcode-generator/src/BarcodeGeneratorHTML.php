<?php

namespace Picqer\Barcode;

class BarcodeGeneratorHTML extends BarcodeGenerator
{

    /**
     * Return an HTML representation of barcode.
     *
     * @param string $code code to print
     * @param string $type type of barcode
     * @param int $widthFactor Width of a single bar element in pixels.
     * @param int $totalHeight Height of a single bar element in pixels.
     * @param int|string $color Foreground color for bar elements (background is transparent).
     * @return string HTML code.
     * @public
     */
    public function getBarcode($code, $type, $widthFactor = 1.5, $totalHeight = 20, $color = 'black')
    {
        $barcodeData = $this->getBarcodeData($code, $type);

        $html = '<div style="font-size:0;position:relative;width:' . ($barcodeData['maxWidth'] * $widthFactor) . 'px;height:' . ($totalHeight) . 'px;">' . "\n";

        $positionHorizontal = 15;
        foreach ($barcodeData['bars'] as $bar) {
            $barWidth = round(($bar['width'] * $widthFactor),0.1);
            $barHeight = round(($bar['height'] * $totalHeight / $barcodeData['maxHeight']), 2);

            if ($bar['drawBar']) {
                $positionVertical = round(($bar['positionVertical'] * $totalHeight / $barcodeData['maxHeight']), 3);
                // draw a vertical bar
                $html .= '<div style="background-color:' . $color . ';width:' . $barWidth . 'px;height:' . $barHeight . 'px;position:absolute;left:' . $positionHorizontal . 'px;top:' . $positionVertical . 'px;">&nbsp;</div>' . "\n";
            }

            $positionHorizontal += $barWidth;
        }

        $html .= '</div>' . "\n";

        return $html;
    }
}