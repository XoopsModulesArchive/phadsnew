<?php

// $Revision: 2.0.2.1 $

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

// Include required files
require __DIR__ . '/lib-xmlrpc.inc.php';

// Create array to pass needed HTTP headers via XML-RPC
$phpAds_remoteInfo = [
    // Headers used for logging/ACLs

'remote_addr' => 'REMOTE_ADDR',
'remote_host' => 'REMOTE_HOST',

    // Headers used for ACLs

'accept_language' => 'HTTP_ACCEPT_LANGUAGE',
'referer' => 'HTTP_REFERER',
'user_agent' => 'HTTP_USER_AGENT',

    // Headers used for proxy lookup

'forwarded' => 'HTTP_FORWARDED',
'forwarded_for' => 'HTTP_FORWARDED_FOR',
'x_forwarded' => 'HTTP_X_FORWARDED',
'x_forwarded_for' => 'HTTP_X_FORWARDED_FOR',
'client_ip' => 'HTTP_CLIENT_IP',
];

/*********************************************************/
/* Class to display banners via XML-RPC                  */

/*********************************************************/

class phpAds_XmlRpc
{
    public $client;

    public $remote_info;

    public $output;

    public function __construct($host, $path, $port = 80)
    {
        $this->connect($host, $path, $port);
    }

    public function connect($host, $path, $port = 80)
    {
        global $phpAds_remoteInfo, $HTTP_SERVER_VARS;

        // Correct trailing slashes

        if (mb_strlen($path)) {
            $path = preg_replace('^/?(.*)/?$', '/\\1', $path);
        }

        // Create client object

        $this->client = new xmlrpc_client($path . '/adxmlrpc.php', $host, $port);

        // Collect remote host information for the adserver

        $this->remote_info = [];

        while (list($k, $v) = each($phpAds_remoteInfo)) {
            if (isset($HTTP_SERVER_VARS[$v])) {
                $this->remote_info[$k] = $HTTP_SERVER_VARS[$v];
            }
        }

        // Encode remote host information into a XML-RPC struct

        $this->remote_info = phpAds_xmlrpcEncode($this->remote_info);

        // Reset $output cache

        $this->output = '';
    }

    public function view_raw($what, $clientid = 0, $target = '', $source = '', $withtext = 0, $context = 0, $richmedia = true)
    {
        // Create context XML-RPC array

        if (is_array($context)) {
            for ($i = 0, $iMax = count($context); $i < $iMax; $i++) {
                $context[$i] = phpAds_xmlrpcEncode($context[$i]);
            }
        } else {
            $context = [];
        }

        $xmlcontext = new xmlrpcval($context, 'array');

        // Create XML-RPC request message

        $msg = new xmlrpcmsg(
            'phpAds.view',
            [
            $this->remote_info,
            new xmlrpcval($what, 'string'),
            new xmlrpcval($clientid, 'int'),
            new xmlrpcval($target, 'string'),
            new xmlrpcval($source, 'string'),
            new xmlrpcval($withtext, 'boolean'),
            $xmlcontext,
        ]
        );

        // Send XML-RPC request message

        if ($response = $this->client->send($msg)) {
            // XML-RPC server found, now checking for errors

            if (0 == $response->faultCode()) {
                $this->output = phpAds_xmlrpcDecode($response->value());

                return $this->output;
            }
        }

        return false;
    }

    public function view($what, $clientid = 0, $target = '', $source = '', $withtext = 0, $context = 0, $richmedia = true)
    {
        $this->view_raw($what, $clientid, $target, $source, $withtext, $context, $richmedia);

        echo $this->output['html'];

        return $this->output['bannerid'];
    }
}
