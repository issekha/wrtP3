<?php

namespace cmsWRT\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use cmsWRT\Domain\Comment;
use cmsWRT\Form\Type\CommentType;

class HomeController {

    /**
     * Home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {
        $articles = $app['dao.article']->findAll();
        return $app['twig']->render('index.html.twig', array('article' => $articles));
    }
    
    /**
     * Article details controller.
     *
     * @param integer $id Article id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function articleAction($id, Request $request, Application $app) {
   		$article = $app['dao.article']->find($id);
   		 $commentFormView = null;
		if ($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
			// A user is fully authenticated : he can add comments
			$comment = new Comment();
			$comment->setArticle($article);
			$user = $app['user'];
			$comment->setAuthor($user);
			$commentForm = $app['form.factory']->create(CommentType::class, $comment);
			$commentForm->handleRequest($request);
			if ($commentForm->isSubmitted() && $commentForm->isValid()) {
				$app['dao.comment']->save($comment);
				$app['session']->getFlashBag()->add('success', 'Your comment was successfully added.');
				return $app->redirect($request->getUri());
			}
		$commentFormView = $commentForm->createView();
		}
		else{
			$comment = new Comment();
			$comment->setArticle($article);
			$user = '';
			$comment->setAuthor($user);
			$commentForm = $app['form.factory']->create(CommentType::class, $comment)
						->add('author');
			$commentForm->handleRequest($request);
			if ($commentForm->isSubmitted() && $commentForm->isValid()) {
				$app['dao.comment']->save($comment);
				$app['session']->getFlashBag()->add('success', 'Your comment was successfully added.');
				return $app->redirect($request->getUri());
			}
			$commentFormView = $commentForm->createView();
		}

		$comments = $app['dao.comment']->findAllByArticle($id);

		return $app['twig']->render('article.html.twig', array(
			'article' => $article, 
			'comments' => $comments,
			'commentForm' => $commentFormView));

	}
    /**
     * User login controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function loginAction(Request $request, Application $app) {
        return $app['twig']->render('login.html.twig', array(
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ));
    }
	// report comment
 public function reportAction($id, Request $request, Application $app){
	$comment = $app['dao.comment']->find($id);
	$nbReport = $comment->getReport();
	$nbReport++;
	$comment->setReport($nbReport);
	$app['dao.comment']->save($comment);
	$app['session']->getFlashBag()->add('warning', 'Ce commantaire à signalé aux admistrateurs');
	
}
}
