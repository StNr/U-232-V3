<?php
/**
 *   https://github.com/Bigjoos/
 *   Licence Info: GPL
 *   Copyright (C) 2010 U-232 v.3
 *   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.
 *   Project Leaders: Mindless, putyn.
 **/

function cleanup_log( $data )
{
  $text = sqlesc($data['clean_title']);
  $added = TIME_NOW;
  $ip = sqlesc($_SERVER['REMOTE_ADDR']);
  $desc = sqlesc($data['clean_desc']);
  sql_query( "INSERT INTO cleanup_log (clog_event, clog_time, clog_ip, clog_desc) VALUES ($text, $added, $ip, {$desc})" ) or sqlerr(__FILE__, __LINE__);
}


function docleanup( $data ) {
        global $INSTALLER09, $queries, $mc1;
        set_time_limit(1200);
        ignore_user_abort(1);
        //== Delete shout
        $secs = 2 * 86400;
        $dt = sqlesc(TIME_NOW - $secs);
        sql_query("DELETE FROM shoutbox WHERE " . TIME_NOW . " - date > $secs") or sqlerr(__FILE__, __LINE__);
        $mc1->delete_value('shoutbox_');
        $mc1->delete_value('staff_shoutbox_');
        if($queries > 0)
        write_log("Shout Clean -------------------- Shout Clean Complete using $queries queries--------------------");
       
        if( false !== mysqli_affected_rows($GLOBALS["___mysqli_ston"]) )
        {
        $data['clean_desc'] = mysqli_affected_rows($GLOBALS["___mysqli_ston"]) . " items deleted/updated";
        }
          
        if( $data['clean_log'] )
        {
        cleanup_log( $data );
        }
        
}
?>
