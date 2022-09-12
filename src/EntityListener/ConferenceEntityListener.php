<?php

namespace App\EntityListener;

use App\Entity\Topics;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class ConferenceEntityListener
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(Topics $topics, LifecycleEventArgs $event)
    {
        $topics->computeSlug($this->slugger);
    }

    public function preUpdate(Topics $topics, LifecycleEventArgs $event)
    {
        $topics->computeSlug($this->slugger);
    }
}