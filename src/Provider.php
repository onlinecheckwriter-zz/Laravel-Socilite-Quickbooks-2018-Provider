<?php

namespace Onlinecheckwriter\Socialite\QuickBooks;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;


class QuickBoooksProvider extends AbstractProvider implements ProviderInterface
{
    /**
     * Unique Provider Identifier.
     */
    const IDENTIFIER = 'QUICKBOOKS2018';

    /**
     * {@inheritdoc}
     */
    protected $scopes = ['com.intuit.quickbooks.accounting', 'openid','profile','email','phone','address'];

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(env("QUICKBOOKS_AUTHORIZATION_ENDPOINT"), $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return env("QUICKBOOKS_TOKEN_ENDPOINT") ;
    }
	
	
	
    /**
     * Get the POST fields for the token request.
     *
     * @param  string  $code
     * @return array
     */
    protected function getTokenFields($code)
    {
		$authrization = "Basic " . base64_encode(env('QUICKBOOKS_KEY').":".env('QUICKBOOKS_SECRET'));
		
        return parent::getTokenFields($code) + ['grant_type' => 'authorization_code'];
    }

	
	  public function getAccessTokenResponse($code)
    {
        $postKey = (version_compare(ClientInterface::VERSION, '6') === 1) ? 'form_params' : 'body';

        $authrization = "Basic " . base64_encode(env('QUICKBOOKS_KEY').":".env('QUICKBOOKS_SECRET'));

        $response = $this->getHttpClient()->post($this->getTokenUrl(), [
            'headers' => ['Accept' => 'application/json',"Authorization"=>$authrization,'Content-Type'=>'application/x-www-form-urlencoded',"Content-Type: application/x-www-form-urlencoded"],
            "body"=>"grant_type=authorization_code&code=$code&redirect_uri=$this->redirectUrl"


        ]);


        return json_decode($response->getBody(), true);
    }

	
	
	
	

    /**
     * {@inheritdoc}
     */
  protected function getUserByToken($token)
    {



       $response = $this->getHttpClient()->get(env("QUICKBOOKS_USERINFO_ENDPOINT"), [

            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

	

    /**
     * {@inheritdoc}
     */
 protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'name' => $user['givenName'].$user['familyName'],'email'=>$user["email"]
        ]);
    }
    /**
     * {@inheritdoc}
     */
   public function fields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }
}
