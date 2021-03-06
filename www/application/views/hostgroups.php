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

<h3><?php echo gettext('Host Groups'); ?></h3>
<div class="contentWrapper">

    <div class="resultFilter">
        <form id="resultfilterform" action="" method="get">
            <label class="label" for="name_filter">Search Host Group Names:</label>
            <input type="text" name="name_filter" value="<?php echo $name_filter; ?>" />
            <input type="submit" name="submitbutton" value="Filter" />
        </form>
    </div>

    <?php

    $illegal_chars = array(' ','.',':','(',')','#','[',']');

    foreach ($data as $group => $group_data) {

        $id = str_replace($illegal_chars, '_', $group);

        // skip ahead if there are no authorized hosts
        if( array_sum($group_data['host_counts']) == 0 ) continue;

        $page = '<h5><a name="'.$group.'">'.$group.'</a></h5>
            <table class="statusable">
                <tr>
                    <th>&nbsp;</th>
                    <th>Up</th>
                    <th>Down</th>
                    <th colspan="2">Unreachable</th>
                </tr>
                <tr>
                    <td>Hosts</td>
                    <td class="ok">'.$group_data['host_counts']['UP'].'</td>
                    <td class="down">'.$group_data['host_counts']['DOWN'].'</td>
                    <td class="unreachable" colspan="2">'.$group_data['host_counts']['UNREACHABLE'].'</td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <th>Ok</th>
                    <th>Warning</th>
                    <th>Critical</th>
                    <th>Unknown</th>
                </tr>
                <tr>
                    <td>Services</td>
                    <td class="ok">'.$group_data['service_counts']['OK'].'</td>
                    <td class="warning">'.$group_data['service_counts']['WARNING'].'</td>
                    <td class="critical">'.$group_data['service_counts']['CRITICAL'].'</td>
                    <td class="unknown">'.$group_data['service_counts']['UNKNOWN'].'</td>
                </tr>
            </table>';

        $page .= '<p class="label"><a onclick="showHide(\''.$id.'\')" href="javascript:void(0)">Toggle Grid</a></p>';

        //details table in GRID view
        $page .= '<div class="hidden" id="'.$id.'">';
        $page .= '<table class="statustable">
                    <tr>
                        <th>'.$group.'</th>
                        <th>Host Status</th>
                        <th>Services</th>
                    </tr>';

        foreach ($group_data['member_data'] as $member => $member_data) {
            $page .= '<tr>';

                //pull group member data from global $hosts array
                $page .= '<td><a href="'.$member_data['host_url'].'">'.$member_data['host_name'].'</a></td>';
                $page .= '<td class="'.$member_data['state_class'].'">'.$member_data['host_state'].'</td>';

                //pull group member data from global $services array
                $page .= '<td>';
                foreach ($member_data['services'] as $service => $service_data) {
                    $page .= '<span class="'.$service_data['state_class'].'"><a href="'.$service_data['service_url'].'">'.$service_data['description'].'</a></span>';
                }
                $page .= '</td>';

            $page .= '</tr>';
        }

        $page .= '</table>';
        $page .= '</div><br />';

        echo $page;

    }

    ?>

</div>
