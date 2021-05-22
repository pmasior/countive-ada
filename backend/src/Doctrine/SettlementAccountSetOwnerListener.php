<?php

namespace App\Doctrine;

use App\Entity\SettlementAccount;

class SettlementAccountSetOwnerListener extends SetOwnerListener
{
    public function prePersist(SettlementAccount $object)
    {
        $this->setOwnerIfNotSet($object);
    }

}
