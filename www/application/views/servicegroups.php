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

<h3><?php echo gettext('Service Groups'); ?></h3>
<div class="contentWrapper">

    <div class="resultFilter">
        <form id="resultfilterform" action="" method="get">
            <label class="label" for="name_filter"><?php echo gettext('Search Service Group Names') ?></label>
            <input type="text" name="name_filter" value="<?php echo $name_filter; ?>"></input>
            <input type="submit" name="submitbutton" value="Filter" />
        </form>
    </div>

    <?php 

    //create two joined tables, one summary, one grid
    foreach ($data as $group => $group_data) {
        $page = '<h5>'.$group.'</h5>';

        $page .= '
            <table class="statustable">
                <thead>
                    <tr>
                        <th>Ok</th>
                        <th>'.gettext('Critical').'</th>
                        <th>'.gettext('Warning').'</th>
                        <th>'.gettext('Unknown').'</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ok">'.$group_data['state_counts']['OK'].'</td>
                        <td class="critical">'.$group_data['state_counts']['CRITICAL'].'</td>
                        <td class="warning">'.$group_data['state_counts']['WARNING'].'</td>
                        <td class="unknown">'.$group_data['state_counts']['UNKNOWN'].'</td>
                    </tr>
                </tbody>
            </table>
        ';

        $page .= '<p class="label"><a onclick="showHide(\''.$group.'\')" href="javascript:void(0)">'.gettext('Toggle Grid').'</a></p>';

        //details table in GRID view
        $grid_rows = array();
        foreach ($group_data['services'] as $serv) {
            //add a hoststatus element to service arrays
            $grid_rows[] = '
                <tr>
                    <td><a href="'.$serv['host_url'].'">'.$serv['host_name'].'</a></td>
                    <td class="'.strtolower($serv['current_state']).'">'.$serv['current_state'].'</td>
                    <td><a href="'.$serv['service_url'].'">'.$serv['description'].'</a></td>
                    <td>'.$serv['plugin_output'].'</td>
                </tr>
            ';
        }
        $grid_rows = implode("\n", $grid_rows);

        $page .= '
            <div class="hidden" id="'.$group.'">
                <table class="statustable">
                    <tbody>
                        <tr>
                            <th>'.gettext('Host').'</th>
                            <th>'.gettext('Status').'</th>
                            <th>'.gettext('Service').'</th>
                            <th>'.gettext('Status Information').'</th>
                        </tr>
                        '.$grid_rows.'
                    </tbody>
                </table>
            </div>
        ';

        echo $page;

    }

    ?>

</div>
