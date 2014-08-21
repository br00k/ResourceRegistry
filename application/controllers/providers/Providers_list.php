<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


/**
 * Jagger
 * 
 * @package     Jagger
 * @author      Middleware Team HEAnet 
 * @copyright   Copyright (c) 2014, HEAnet Limited (http://www.heanet.ie)
 * @license     MIT http://www.opensource.org/licenses/mit-license.php
 *  
 */

/**
 * Providers_list Class
 * 
 * @package     Jagger
 * @author      Janusz Ulanowski <janusz.ulanowski@heanet.ie>
 */

class Providers_list extends MY_Controller {

    function __construct()
    {
        parent::__construct();
       $this->output->set_content_type('application/json');
    }

    /**
     * get list provider via ajax
     */
    function show($type)
    {
       
        if(!$this->input->is_ajax_request())
        {
           set_status_header(403);
           echo 'Request not allowed';
           return;
        }
        if(strcmp($type,'idp')!=0 && strcmp($type,'sp')!=0)
        {
           set_status_header(404);
           echo 'Incorrect type of entities provided';
           return;
        }
        $loggedin = $this->j_auth->logged_in();
        if (!$loggedin)
        {
           set_status_header(403);
           echo 'Not authenticated - access denied';
           return;
        }
        $this->load->library('zacl');
        $resource = 'idp_list';
        $action = 'read';
        $group = 'default';
        $has_read_access = $this->zacl->check_acl($resource, $action, $group, '');
        if (!$has_read_access)
        {
           set_status_header(403);
           echo 'no permission';
           return;
       }
       
       $result = $this->getList($type);   

       echo json_encode($result);

    }


    private function getList($type)
    {
       $lang = MY_Controller::getLang();
       $keyprefix = getCachePrefix();
       $this->load->driver('cache', array('adapter' => 'memcached', 'key_prefix' => $keyprefix));

       $cachedid = $type.'_l_'.$lang;
       $result['data'] = array();

       $result['columns'] = array(
         'nameandentityid'=>array('colname'=>'Provider name','status'=>1, 'cols'=>array('pname','pentityid')),
         'pregdate'=>array('colname'=>'Registration date','status'=>1,'cols'=>array('pregdate')),
        // 'url'=>array('colname'=>'Url','status'=>1,'cols'=>array('phelpurl')),
          

       );

       $cachedResult = $this->cache->get($cachedid);
       if(empty($cachedResult))
       {
          log_message('debug','list of '.$type.'(s) for lang ('.$lang.') not found in cache ... retriving from db');
          $tmpprovs = new models\Providers();
          if(strcmp($type,'idp')==0)
          {
             $list = $tmpprovs->getIdpsLight();
          }
          else
          {
             $list = $tmpprovs->getSpsLight();
          }
          $i = 0;
          foreach($list as $v)
          {
             $rdate = $v->getRegistrationDate();
             if(isset($rdate))
             {
                $regdate = date('Y-m-d',$rdate->format('U')+j_auth::$timeOffset);
             }
             else
             {
                $regdate = '';
             }
             $data['"'.$i++.'"'] = array(
               'pid'=>$v->getId(),
               'plocked'=>(int)$v->getLocked(),
               'pactive'=>(int)$v->getActive(),
               'plocal'=>(int)$v->getLocal(),
               'pstatic'=>(int)$v->getStatic(),
               'pvisible'=>(int)$v->getPublicVisible(),
               'pavailable'=>(int)$v->getAvailable(),
               'pentityid'=>$v->getEntityId(),
               'pname'=>$v->getNameToWebInLang($lang,$type),
               'pregdate'=>$regdate,
               'phelpurl'=>$v->getHelpdeskUrl(),
             );

          }
          if(count($data)>0)
          {
             $this->cache->save($cachedid, $data, 180);
          }
          $result['data'] = &$data;
          return $result;
    
       }
       else
       {
         $result['data'] = &$cachedResult;
         return $result;
       }

    }

}
