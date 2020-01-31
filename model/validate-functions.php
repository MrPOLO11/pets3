<?php

/* validate a color
 * @param String color
 * @return boolean
 */
function validColor($color)
{
    global $f3;
    return in_array($color, $f3->get('colors'));
}
function validString($string)
{
    global $f3;
    return cytype_alpha($string);

}