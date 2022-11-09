<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

class Authenticator extends AbstractAuthenticator
{

    public function __construct(JWTEncoderInterface $event)
    {
	    $this->jwtEncoder = $event;
    }
    public function supports(Request $request): ?bool
    {
        return $request->headers->has('x-api-key');
	}
    public function authenticate(Request $request): Passport
    {
        $apiToken = $request->headers->get('x-api-key');
		if (null === $apiToken)
		{
            throw new CustomUserMessageAuthenticationException('No API token provided');
        }
		$data = $this->jwtEncoder->decode($apiToken);
        if ($data === false) 
        {
            throw new CustomUserMessageAuthenticationException('Invalid Token');
        }
        $email = $data['email'];
		return new SelfValidatingPassport(new UserBadge($email));
    }
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
           'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ];
        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}
?>