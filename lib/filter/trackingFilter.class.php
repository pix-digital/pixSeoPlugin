<?php
class trackingFilter extends sfFilter{

	public function execute ($filterChain)
	{

		if ($this->isFirstCall())
		{
			// Code to execute before the action execution
			$request = $this->getContext()->getRequest();
			$host = $request->getHost();
			$referer = $request->getReferer();

			
      if ($request->getParameter('pix-ref')) {
      
        $referer = $request->getParameter('pix-ref');
        $refererHost = $request->getParameter('pix-src');
        $refererKeywords = $request->getParameter('pix-key');
      
        setcookie(sfConfig::get('app_cookie_name'),
          "referer=".$referer."&host=".$refererHost."&keywords=".$refererKeywords, 
          time()+60*60*24*30*2, '/', $host);	
        
      } elseif($referer && !$request->getCookie(sfConfig::get('app_cookie_name'))){
					
				$refererHost = $this->getHostFromRequest($referer);
				$refererKeywords = $this->getKeyWordsFromRequest($refererHost, $referer);

				setcookie(sfConfig::get('app_cookie_name'),
				"referer=".$referer."&host=".$refererHost."&keywords=".$refererKeywords, 
				time()+60*60*24*30*2, '/', $host);
			}
			 
		}

		// Execute next filter in the chain
		$filterChain->execute();

		// Code to execute after the action execution, before the rendering
	  
	}

	public function getHostFromRequest($request){
		$t = explode("/", $request);
		if(!is_array($t) || !array_key_exists(2, $t)){
			return null;
		}
		return $t[2];
	}


	public function getKeyWordsFromRequest($host, $request){

		if(is_null($host)){
			return null;
		}

		// on nettoie le host pour que ca corresponde aux case
		$host = str_replace('www.', '', $host);
		// cas pour google
		if(preg_match("/google/", $host)){
			$host = 'google';
		}
		// cas pour yahoo
		if(preg_match("/yahoo/", $host)){
			$host = 'yahoo';
		}

			
		switch($host){

			case 'yahoo'     	 :  $param = "p="; break;
			case 'altavista.com' :  $param = "q="; break;
			case 'google'        :  $param = "q="; break;
			case 'bing.com'      :  $param = "q="; break;
			case 'lycos'         :  $param = "query="; break;
			case 'hotbot'        :  $param = "query="; break;
			case 'search.msn'    :  $param = "q="; break;
			case 'netscape.com'  :  $param = "query="; break;
			case 'mamma.com'     :  $param = "query="; break;
			case 'alltheweb.com' :  $param = "q="; break;
			case 'ledepart.com'  :  $param = "q="; break;
			case 'entireweb.com' :  $param = "q="; break;
			case 'dir.com'       :  $param = "req="; break;
			case 'ask.com'       :  $param = "q="; break;
			case 'dmoz.org'      :  $param = "search="; break;
			case 'looksmart.com' :  $param = "key="; break;
			case 'aol.com'       :  $param = "query="; break;
			case 'alexa.com'     :  $param = "q="; break;
			case 'wisenut.com'   :  $param = "q="; break;
			case 'overture.com'  :  $param = "Keywords="; break;
			case 'net.net'       :  $param = "Keywords="; break;
			case 'oemji.com'     :  $param = "Keywords="; break;
			case 'skynet.be'     :  $param = "keywords="; break;
			case 'mirago.fr'     :  $param = "qry="; break;
			case 'excite.fr'     :  $param = "q="; break;
			case 'netscape.fr'   :  $param = "q="; break;
			case 'voila.fr'      :  $param = "rdata="; break;
			case 'tiscali.fr'    :  $param = "s="; break;
			case 'dmoz.fr'       :  $param = "search="; break;
			case 'aol.fr'        :  $param = "q="; break;
			case 'neuf.fr'       :  $param = "keywords="; break;
			case 'recherche.fr'  :  $param = "keywords="; break;
			case 'illiko.com'    :  $param = "Keywords="; break;
			case 'antisearch.net':  $param = "KEYWORDS="; break;
			case 'localhost'     : $param = "q="; break;
			default : $param = "/"; break;
		}

		$chaine = explode($param, $request);
		if(!is_array($chaine) || !array_key_exists(1, $chaine)){
			return null;
		}
		$str = parse_str($param.$chaine[1]);
		$substr_param = substr($param,0,-1);
		if(!isset($$substr_param)){
			return null;
		}
		return $$substr_param;
	}


}