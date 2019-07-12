<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class BlogPostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $blogPost = new BlogPost();
            $blogPost->setTitle("Mon BlogPost $i");
            $blogPost->setSlug("Slug");
            $blogPost->setContent("Sample Content");
            $blogPost->setDate(new \DateTime('12/07/2019'));
            $blogPost->setCategory("Category_1");
            $blogPost->setFeatured(TRUE);

            $manager->persist($blogPost);
        }

        $manager->flush();
    }
}
