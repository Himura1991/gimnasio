<?php

namespace GimnasioBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class GimnasioBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
