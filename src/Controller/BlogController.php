<?php
/**
 * Created by PhpStorm.
 * User: ladam
 * Date: 2/11/2019
 * Time: 9:08 PM
 */

namespace App\Controller;


use App\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


/**
 * @Route("/blog")
 * Class BlogController
 * @package App\Controller
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/{page}", name="blog_list", defaults={"page":5}, requirements={"page"="\d+"})
     */
    public function list($page = 1, Request $request)
    {
        $limit = $request->get('limit', 10);

        $repository = $this->getDoctrine()->getRepository(BlogPost::class);
        $items = $repository->findAll();


        return $this->json(
            [
                'page' => $page,
                'limit' => $limit,
                'data' => array_map(function (BlogPost $item) {
                    return $this->generateUrl('blog_by_id', ['id' => $item->getId()]);
                }, $items)
            ]
        );
    }

    /**
     * @Route("/post/{id}", name="blog_by_id", requirements={"id"="\d+"})
     * @ParamConverter("post", class="App:BlogPost")
     */
    public function post(BlogPost $post)
    {
        return $this->json($post); // this is the same as doing find($id)
    }

    /**
     * @Route("/post/{slug}", name="blog_by_slug")
     * @ParamConverter("post", options={"mapping", {"slug", "slug"}})
     */
    public function postBySlug(BlogPost $post)
    {
//        return $this->json(
//            $this->getDoctrine()->getRepository(BlogPost::class)->findBy(['slug' => $slug])
//        );
        // same as above
        return $this->json($post);
    }

    /**
     * @Route("/add", name="blog_add", methods={"POST"})
     */
    public function add(Request $request)
    {
        /**
         * @var Serializer $serializer
         */
        $serializer = $this->get('serializer');

        $blogPost = $serializer->deserialize($request->getContent(), BlogPost::class, 'json');

        $em = $this->getDoctrine()->getManager();

        $em->persist($blogPost);
        $em->flush();

        return $this->json($blogPost);
    }
}