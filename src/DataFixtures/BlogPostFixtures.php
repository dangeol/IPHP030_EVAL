<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class BlogPostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category1 = $manager
            ->getRepository(Category::class)
            ->findOneBy(array('id' => 1));
        $category2 = $manager
            ->getRepository(Category::class)
            ->findOneBy(array('id' => 2));

        for ($i = 0; $i < 8; $i++) {
            $blogPost = new BlogPost();
            $blogPost->setTitle("Mon BlogPost $i");
            $blogPost->setSlug("Slug");
            $blogPost->setContent("Sample Content");
            $blogPost->setDate(new \DateTime('12/07/2019'));
            if ($i%2 === 0) {
                $blogPost->setCategory($category1);
                $blogPost->setFeatured(TRUE);
            } else {
                $blogPost->setCategory($category2);
                $blogPost->setFeatured(FALSE);
            }

            $manager->persist($blogPost);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CategroyFixtures::class
        );
    }
}
