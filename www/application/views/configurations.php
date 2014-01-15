<?php

// Nagios V-Shell
// Copyright (c) 2010 Nagios Enterprises, LLC.
// Written by Mike Guthrie <mguthrie@nagios.com>
//
// LICENSE:
//
// This work is made available to you under the terms of Version 2 of
// the GNU General Public License. A copy of that license should have
// been provided with this software, but in any event can be obtained
// from http://www.fsf.org.
//
// This work is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
// 02110-1301 or visit their web page on the internet at
// http://www.fsf.org.
//
//
// CONTRIBUTION POLICY:
//
// (The following paragraph is not intended to limit the rights granted
// to you to modify and distribute this software under the terms of
// licenses that may apply to the software.)
//
// Contributions to this software are subject to your understanding and acceptance of
// the terms and conditions of the Nagios Contributor Agreement, which can be found
// online at:
//
// http://www.nagios.com/legal/contributoragreement/
//
//
// DISCLAIMER:
//
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
// INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
// PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
// HOLDERS BE LIABLE FOR ANY CLAIM FOR DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
// OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
// GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, STRICT LIABILITY, TORT (INCLUDING
// NEGLIGENCE OR OTHERWISE) OR OTHER ACTION, ARISING FROM, OUT OF OR IN CONNECTION
// WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

?>

    <?php 
    //commented out, needs further revisions to be used on config pages.  Only host filter works right now -MG
    /*
    <div class='resultFilter'>
        <form id='resultfilterform' action='{$_SERVER['PHP_SELF']}' method='get'>
            <input type="hidden" name="type" value="$type">
            <input type="hidden" name="objtype_filter" value="$objtype_filter">
            <label class='label' for='name_filter'>Search Configuration Name:</label>
            <input type="text" name='name_filter' value="$name_filter"></input>
            <input type='submit' name='submitbutton' value='Filter' />
        </form>
    </div>
    */ 
    ?>

    <?php 

    $count = 0;
    $object_list = '<ul class="configlist">';

    foreach ($data as $a) {

        //default for no permissions
        $title = '';
        $linkkey = '';

        //change variables based on type of object being viewed
        switch ($objtype_filter) {
            case 'hosts_objs':
                $name = $a['host_name'];
                $linkkey = 'host'.$a['host_name'];
                #$link = htmlentities(BASEURL.'index.php?cmd=gethostdetail&arg='.$name);
                $link = htmlentities(BASEURL.'index.php?type=hostdetail&name_filter=').urlencode($name);
                $title = gettext('Host').": <a href='$link' title='Host Details'>$name</a>";
            break;

            case 'services_objs':
                $count++;
                $name=$a['service_description'];
                $linkkey = 'service'.$count;
                $host = $a['host_name'];
                #$hlink = htmlentities(BASEURL.'index.php?cmd=gethostdetail&arg='.$host);
                $hlink = htmlentities(BASEURL.'index.php?type=hostdetail&name_filter=').urlencode($host);
                #$link = htmlentities(BASEURL.'index.php?cmd=getservicedetail&arg='.$linkkey);
                $link = htmlentities(BASEURL.'index.php?type=servicedetail&name_filter='.$linkkey);
                $title = gettext('Host').": <a href='$hlink' title='Host Details'>$host</a>
                            ".gettext('Service').":<a href='$link' title='Service Details'>$name</a>";

            break;

            case 'commands':
                $name=$a['command_name'];
                $title = gettext('Command').": $name";
                $linkkey = $name;
            break;

            case 'hostgroups_objs':
                $name=$a['hostgroup_name'];
                $title = gettext('Group Name').": $name";
                $linkkey = 'hg'.$name;
            break;

            case 'servicegroups_objs':
                $name=$a['servicegroup_name'];
                $title = gettext('Group Name').": $name";
                $linkkey = 'sg'.$name;
            break;

            case 'timeperiods':
                $name=$a['timeperiod_name'];
                $title = gettext('Timeperiod').": $name";
                $linkkey = 'tp'.$name;
            break;

            case 'contacts':
                $name=$a['contact_name'];
                $title = gettext('Contact').": $name";
                $linkkey = $name;
            break;

            case 'contactgroups':
                $name=$a['contactgroup_name'];
                $title = gettext('Contact Group').": $name";
                $linkkey = $name;
            break;

            default:
                $title = gettext('Access Denied').'<br />';
                $linkkey = gettext('You do not have permissions to view this information');
            break;

        }

        //replacing dots with underscores
        $id = preg_replace('/[\. ]/', '_', $linkkey);

        $confighead = "

        <li class='configlist'>{$title} <a class='label' onclick='showHide(\"{$id}\")' href='javascript:void(0)'>
        <img class='label' src='".IMAGESURL."/expand.gif' title='Show Config' alt='Image' height='12' width='12' />
        </a></li>

        <div class='hidden' id='{$id}'>

        <table class='objectList'>
        <tr><th>".gettext('Config')."</th><th>".gettext('Value')."</th></tr>

        ";

        if ($title != '') { //only display if authorized
            $object_list .= $confighead;

            //print raw config data into a table
            foreach ($a as $key => $value) {
                $object_list .= '
                    <tr class="objectList">
                        <td>'.$key.'</td>
                        <td>'.$value.'</td>
                    </tr>
                ';
            }
            $object_list .= "</table></div>";
        }
    }

    $object_list .= "<ul>";

    echo $object_list;