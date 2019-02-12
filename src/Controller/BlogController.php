<?php
/**
 * Created by PhpStorm.
 * User: ladam
 * Date: 2/11/2019
 * Time: 9:08 PM
 */

namespace App\Controller;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/blog")
 * Class BlogController
 * @package App\Controller
 */
class BlogController
{

    private const POSTS = [
        [
            'id' => 1,
            'slug' => 'hello-world',
            'title' => 'Hello World!'
        ],
        [
            'id' => 2,
            'slug' => 'another-post',
            'title' => 'Thsi is another post!'
        ],
        [
            'id' => 3,
            'slug' => 'last-example',
            'title' => 'This is the last example'
        ]
    ];

    /**
     * @Route("/{page}", name="blog_list", defaults={"page":5})
     */
    public function list($page = 1)
    {
        return new JsonResponse(
            [
                'page' => $page,
                'data' => self::POSTS
            ]
        );
    }

    /**
     * @Route("/{id}", name="blog_by_id", requirements={"id"="\d+"})
     */
    public function post($id)
    {
        return new JsonResponse(
            self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
        );
    }

    /**
     * @Route("/{slug}", name="blog_by_slug")
     */
    public function postBySlug($slug)
    {
        return new JsonResponse(
            self::POSTS[array_search($slug, array_column(self::POSTS, 'slug'))]
        );
    }
}