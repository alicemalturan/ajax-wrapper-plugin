<?php

namespace AliCemalTuran\AjaxWrapper\Classes;

class AjaxPartialTokenParser extends WrapperPartialTokenParser
{
    /**
     * getTag name associated with this token parser
     */
    public function getTag()
    {
        return 'wrappedAjaxPartial';
    }
}
