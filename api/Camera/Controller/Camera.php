<?php namespace Api\Camera\Controller;

use Phprest\Util\Controller;
use Phprest\Exception;
use Phprest\Service;
use Phprest\Response;
use Phprest\Annotation as Phprest;
use Symfony\Component\HttpFoundation\Request;
use Api\Camera\Entity;

class Camera extends Controller
{
    use Service\Hateoas\Getter, Service\Orm\Getter, Service\RequestFilter\Getter;
    use Service\Hateoas\Util, Service\Validator\Util, Service\RequestFilter\Util;

    /**
     * @Phprest\Route(method="GET", path="/camera")
     *
     * @param Request $request
     *
     * @return Response\Ok
     *
     * @throws Exception\NotFound
     */
    public function get(Request $request)
    {
        $repo = $this->serviceOrm()->getRepository('Api\Camera\Entity\Camera');

        if (is_null($camera = $repo->findOneBy([]))) {
            throw new Exception\NotFound();
        }

        return new Response\Ok($camera);
    }

    /**
     * @Phprest\Route(method="POST", path="/camera")
     *
     * @param Request $request
     *
     * @return Response\Created
     *
     * @throws Exception\BadRequest
     */
    public function post(Request $request)
    {
        $transition = $request->query->get('transition');
        $repo = $this->serviceOrm()->getRepository('Api\Camera\Entity\Camera');

        try {
            $camera = $repo->findOneBy([]);

            if (is_null($camera)) {
                $camera = new Entity\Camera($transition);
            } else {
                $camera->setState($transition);
            }

            $this->serviceOrm()->persist($camera);
            $this->serviceOrm()->flush();

        } catch (\Exception $e) {
            throw new Exception\BadRequest(0, [$e->getMessage()]);
        }

        return new Response\Ok($camera);
    }

    /**
     * @Phprest\Route(method="OPTIONS", path="/camera")
     *
     * @return Response\Ok
     */
    public function options()
    {
        return new Response\Ok('', ['Allow' => 'GET,POST,OPTIONS']);
    }
}
