<?php namespace Api\Token\Controller;

use Phprest\Util\Controller;
use Phprest\Response;
use Phprest\Exception;
use Phprest\Service;
use Phprest\Annotation as Phprest;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\Exception\RuntimeException;
use Api\Token\Entity;
use Namshi\JOSE\SimpleJWS;

class Token extends Controller
{
    use Service\Hateoas\Getter, Service\Orm\Getter, Service\RequestFilter\Getter;
    use Service\Hateoas\Util, Service\Validator\Util, Service\RequestFilter\Util;

    /**
     * @Phprest\Route(method="POST", path="/tokens")
     *
     * @param Request $request
     *
     * @return Response\Created
     *
     * @throws Exception\UnprocessableEntity
     * @throws Exception\Unauthorized
     */
    public function post(Request $request)
    {
        try {
            /** @var Entity\Credential $credentials */
            $credentials = $this->deserialize('Api\Token\Entity\Credential', $request);
        } catch (RuntimeException $e) {
            throw new Exception\UnprocessableEntity(0, [new Service\Validator\Entity\Error('', $e->getMessage())]);
        }

        if (count($errors = $this->getErrors($credentials))) {
            throw new Exception\UnprocessableEntity(0, $this->getFormattedErrors($errors));
        }

        if ($credentials->email === 'info@phprest.com' && $credentials->password === 'info') {
            $jws = new SimpleJWS(['alg' => 'HS256']);
            $jws->setPayload([
                'uid' => 1,             # e.g. user id
                'iat' => 1448201407,    # e.g.(new \DateTime())->getTimestamp()
            ]);

            $jws->sign('secret-key');

            return new Response\Ok(['token' => $jws->getTokenString()]);
        }

        throw new Exception\Unauthorized();
    }
}
