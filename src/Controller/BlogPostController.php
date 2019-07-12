<?php
// src/Controller/BlogController.php
namespace App\Controller;
use App\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\BlogPostType;
use App\Form\BlogPostDeleteType;
use Symfony\Component\Routing\Annotation\Route;
class BlogPostController extends AbstractController

{
	/**
	 * Matches blogPost exactly
	 * @Route("/blog/list", name="blogPost_list")
	 */
	public function listPostsAction()
	{
        $blogPost = $this->getDoctrine()
            ->getRepository(BlogPost::class)
            ->findAll();

        return $this->render('blogpost/list.html.twig', ['blogPost' => $blogPost]);
	}

    /**
     * Finds featured BlogPosts
     * @Route("/blog/list_featured", name="blogPost_list_featured")
     */
    public function listFeaturedPostsAction()
    {
        $blogPost = $this->getDoctrine()
            ->getRepository(BlogPost::class)
            ->findBy(array('featured' => TRUE));

        return $this->render('blogpost/list_filtered.html.twig', ['blogPost' => $blogPost]);
    }

    /**
     * Search for a blogPost
     * @Route("/blog/{id}", name="blogPost_byId")
     * @Route("/blog/slug", requirements={"slug"="[a-zA-Z0-9-_]*"})
     * @Route("/blog/date/slug", requirements={"date"="[0-9]{4}*"})
     */
    public function showPostAction($id)
    {
        $blogPost = $this->getDoctrine()
            ->getRepository(BlogPost::class)
            ->find($id);

        if (!$blogPost) {
            throw $this->createNotFoundException(
                'No blogPost found for id '.$id
            );
        }

        return $this->render('blogpost/byId.html.twig', [ 'blogPost' => $blogPost ]);
    }

    /**
     * Create new blogPost in a form
     * @Route("/admin/new-post", name="new_blogPost")
     */
    public function new(Request $request)
    {
        $blogPost = new BlogPost();

        $form = $this->createForm(BlogPostType::class, $blogPost);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blogPost);
            $em->flush();

            return $this->redirectToRoute('blogPost_list', array('id' => $blogPost->getId()));
        }

        return $this->render('blogpost/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Updates a blogPost
     * @param BlogPost $blogPost
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/admin/update-post/{blogPost}", name="blogPost_update")
     */
    public function updateBlogPost(BlogPost $blogPost, Request $request)
    {

        if (!$blogPost) {
            throw $this->createNotFoundException(
                'No blogPost found for blogPost '.$blogPost
            );
        }

        $form = $this->createForm(BlogPostType::class, $blogPost);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blogPost);
            $em->flush();

            return $this->redirectToRoute('blogPost_list');
        }

        return $this->render('blogpost/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a blogPost
     * @param BlogPost $blogPost
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/admin/delete-post/{blogPost}", name="blogPost_delete")
     */
    public function deleteBlogPost(BlogPost $blogPost, Request $request)
    {
        if (!$blogPost) {
            throw $this->createNotFoundException(
                'No blogPost found for blogPost'.$blogPost
            );
        }

        $deleteForm = $this->createForm(BlogPostDeleteType::class, $blogPost);
        $deleteForm->handleRequest($request);

        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($blogPost);
            $em->flush();

            return $this->redirectToRoute('blogPost_list');
        }

        return $this->render('blogpost/delete.html.twig', [
            'delete_form' => $deleteForm->createView(),
        ]);
    }
}