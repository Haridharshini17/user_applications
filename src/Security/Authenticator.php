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
use App\Repository\EndUserRepository;

class Authenticator extends AbstractAuthenticator
{

    public function __construct(EndUserRepository $email)
    {
        $this->EndUserRepository = $email;
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
		$tokenParts = explode(".", $apiToken);  
        $emailToken = base64_decode($tokenParts[1]);
	    $extractEmail = json_decode($emailToken);
        $email = $extractEmail->email;
        return new SelfValidatingPassport(new UserBadge(($email)));   
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