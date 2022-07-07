<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait; 

class MainAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;
    /**
     * @var Security
     */
    public const LOGIN_ROUTE = 'app_login';

    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator,Security $security)
    {

        $this->security = $security;
        $this->urlGenerator = $urlGenerator;
    }
 

    public function authenticate(Request $request): PassportInterface
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        
 

       if ($this->security->getUser()->getRoles()[0] == 'ROLE_ADMIN' ) { 

            return new RedirectResponse($this->urlGenerator->generate('web_master_route'));
        
        }else if( $this->security->getUser()->getRoles()[0] == 'ROLE_CLIENT' ){ 
            return new RedirectResponse($this->urlGenerator->generate('eventoo_dashboard_route'));
           
        }else if( $this->security->getUser()->getRoles()[0] == 'ROLE_PARTICIPANT' ){
            return new RedirectResponse($this->urlGenerator->generate('app_dashboard_route')); 
        }
         
    }

    protected function getLoginUrl(Request $request): string
    {
        $id = $request->get("eventID");
        if ($id == null) {
            return $this->urlGenerator->generate(self::LOGIN_ROUTE);
        } else {
            return $this->urlGenerator->generate(self::LOGIN_ROUTE,['eventID'=>$id]);
        }
        
        
        
    }
}
