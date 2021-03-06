<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hosts extends VS_Controller
{
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

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->helper('fetch_icons_helper');
        $hosts = hosts_and_services_data(
            'hosts',
            $this->state_filter,
            $this->name_filter
        );

        //if results are greater than number that the page can display, create page links
        //calculate number of pages
        $resultsCount = count($hosts);
        $pageCount = (($resultsCount / $this->limit_filter) < 1) ? 1 : intval($resultsCount/$this->limit_filter);
        $doPagination = ($pageCount * $this->limit_filter) < $resultsCount;

        $hostnames = array_keys($hosts);
        sort($hostnames);

        $data = array(
            'hosts'        => $hosts,
            'hostnames'    => $hostnames,
            'start'        => $this->start_filter,
            'limit'        => $this->limit_filter,
            'resultsCount' => $resultsCount,
            'pageCount'    => $pageCount,
            'doPagination' => $doPagination,
            'name_filter'  => $this->name_filter,
            'state_filter' => $this->state_filter,
        );

        $this->load->view('header');
        $this->load->view('hosts', $data);
        $this->load->view('footer');
    }
}

/* End of file hosts.php */
/* Location: ./application/controllers/hosts.php */
