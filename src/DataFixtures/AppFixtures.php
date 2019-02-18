<?php
/**
 * Created by PhpStorm.
 * User: ladam
 * Date: 2/17/2019
 * Time: 6:34 PM
 */

namespace App\DataFixtures;


use App\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $blogPost = new BlogPost();
        $blogPost->setTitle("A first post!");
        $blogPost->setPublished(new \DateTime('2019-02-17 12:00:00'));
        $blogPost->setContent('Post text!');
        $blogPost->setSlug('a-first-post');

        $manager->persist($blogPost);

        $blogPost = new BlogPost();
        $blogPost->setTitle("A second post!");
        $blogPost->setPublished(new \DateTime('2019-02-17 12:00:00'));
        $blogPost->setContent('Post text!');
        $blogPost->setSlug('a-second-post');

        $manager->persist($blogPost);

        $manager->flush();
    }

}