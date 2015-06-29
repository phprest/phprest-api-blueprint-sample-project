<?php namespace Api\Temperature\Controller;

use Phprest\Util\Controller;
use Phprest\Response;
use Phprest\Exception;
use Phprest\Service;
use Phprest\Annotation as Phprest;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\Exception\RuntimeException;
use Api\Temperature\Entity;
use Doctrine\Common\Collections\Criteria;

class Temperature extends Controller
{
    use Service\Hateoas\Getter, Service\Orm\Getter, Service\RequestFilter\Getter;
    use Service\Hateoas\Util, Service\Validator\Util, Service\RequestFilter\Util;

    /**
     * @Phprest\Route(method="GET", path="/temperatures/{id:number}")
     *
     * @param Request $request
     * @param string $version
     * @param integer $id
     *
     * @return Response\Ok
     *
     * @throws Exception\NotFound
     */
    public function get(Request $request, $version, $id)
    {
        $repo = $this->serviceOrm()->getRepository('Api\Temperature\Entity\Temperature');

        if (is_null($temperature = $repo->find($id))) {
            throw new Exception\NotFound();
        }

        return new Response\Ok($temperature);
    }

    /**
     * @Phprest\Route(method="GET", path="/temperatures")

     * @param Request $request
     *
     * @return Response\Ok
     *
     * @throws Exception\NotFound
     * @throws Exception\BadRequest
     */
    public function getAll(Request $request)
    {
        $criteria = Criteria::create();
        $processor = new Service\RequestFilter\Processor\Orm($criteria, [
            'created' => function($value) {
                return new \DateTime($value);
            }
        ]);

        try {
            $this->serviceRequestFilter()->processQuery($request, $processor);
            $this->serviceRequestFilter()->processSort($request, $processor);
        } catch (\Exception $e) {
            throw new Exception\BadRequest(0, [$e->getMessage()]);
        }

        $repo = $this->serviceOrm()->getRepository('Api\Temperature\Entity\Temperature');

        try {
            $temperatures = $repo->matching($criteria);
        } catch (\Exception $e) {
            throw new Exception\BadRequest(0, [$e->getMessage()]);
        }

        if ( ! count($temperatures)) {
            throw new Exception\NotFound();
        }

        return new Response\Ok($temperatures);
    }

    /**
     * @Phprest\Route(method="DELETE", path="/temperatures/{id:number}")
     *
     * @param Request $request
     * @param string $version
     * @param integer $id
     *
     * @return Response\NoContent
     *
     * @throws Exception\NotFound
     */
    public function delete(Request $request, $version, $id)
    {
        $repo = $this->serviceOrm()->getRepository('Api\Temperature\Entity\Temperature');

        if (is_null($temperature = $repo->find($id))) {
            throw new Exception\NotFound();
        }

        $this->serviceOrm()->remove($temperature);
        $this->serviceOrm()->flush();

        return new Response\NoContent();
    }

    /**
     * @Phprest\Route(method="POST", path="/temperatures")
     *
     * @param Request $request
     *
     * @return Response\Created
     *
     * @throws Exception\UnprocessableEntity
     */
    public function post(Request $request)
    {
        try {
            /** @var Entity\Temperature $temperature */
            $temperature = $this->deserialize('Api\Temperature\Entity\Temperature', $request);
        } catch (RuntimeException $e) {
            throw new Exception\UnprocessableEntity(0, [new Service\Validator\Entity\Error('', $e->getMessage())]);
        }

        if (count($errors = $this->getErrors($temperature))) {
            throw new Exception\UnprocessableEntity(0, $this->getFormattedErrors($errors));
        }

        $this->serviceOrm()->persist($temperature);
        $this->serviceOrm()->flush();

        return new Response\Created($request->getSchemeAndHttpHost() . '/temperatures/' . $temperature->id);
    }

    /**
     * @Phprest\Route(method="OPTIONS", path="/temperatures")
     *
     * @return Response\Ok
     */
    public function optionsAll()
    {
        return new Response\Ok('', ['Allow' => 'GET,POST,OPTIONS']);
    }

    /**
     * @Phprest\Route(method="OPTIONS", path="/temperatures/{id:number}")
     *
     * @param Request $request
     * @param string $version
     * @param integer $id
     *
     * @return Response\Ok
     *
     * @throws Exception\NotFound
     */
    public function options(Request $request, $version, $id)
    {
        $repo = $this->serviceOrm()->getRepository('Api\Temperature\Entity\Temperature');

        if (is_null($temperature = $repo->find($id))) {
            throw new Exception\NotFound();
        }

        return new Response\Ok('', ['Allow' => 'GET,DELETE,OPTIONS']);
    }
}
