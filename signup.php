<?php
require_once './include/db.php';
session_start();
if(!empty($_SESSION['user'])){
	header("Location: login.php");
}
 ?>

<!DOCTYPE html>
<html lang="en">
  
<?php require('header.php'); ?>
<style>
#frmCheckPassword {
    border-top: #F0F0F0 2px solid;
    background: #808080;
    padding: 10px;
}

.demoInputBox {
    padding: 7px;
    border: #F0F0F0 1px solid;
    border-radius: 4px;
}

#password-strength-status {
    padding: 5px 10px;
    color: #FFFFFF;
    border-radius: 4px;
    margin-top: 5px;
}

.medium-password {
    background-color: #ffd35e;
    border: #ffd35e 1px solid;
}

.weak-password {
    background-color: #ff4545;
    border: #ff4545 1px solid;
}

.strong-password {
    background-color: #3abb1c;
    border: #3abb1c 1px solid;
}

.loader:before {
 width: 60px;
  height: 60px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
  display: inline-block;
  border: 10px solid #3498db;
  border-radius: 50%;
  border-top: 10px solid #f3f3f3;
  content: "";
}
.loader {
    width: 100%;
    position: fixed;
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 12;
    background: rgba(0,0,0,.8);
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<body>

<div class="loader" style="display: none;"></div>
<div class="account-container register_form">
	
	<div class="login-content">
	
		<div class="loginCenter">
			<div class="content clearfix">
				
				<form id="form" role="form" action="./include/signup.php" method="POST">
				
					
					<div class="login-fields">
						
						<h4 class="welcomeCS">Create Account</h4>
						<div class="field">
							<label for="firstname">First Name</label>
							<input type="text" id="firstname" name="firstname" value="" placeholder="First Name" class="login name-field" />
						</div> <!-- /field -->
						<div class="field">
							<label for="lastname">Last Name</label>
							<input type="text" id="lastname" name="lastname" value="" placeholder="Last Name" class="login name-field" />
						</div> <!-- /field -->
						
						<div class="field">
							<label for="emailaddress">Email</label>
							<input class="login email-field" id="emailaddress" name="emailaddress" type="email" aria-describedby="emailHelp" placeholder="Enter Email Address">
							<div id="email-error" class="fail"></div>
						</div> <!-- /field -->

						<div class="field">
							<label for="organizationname">Organization Name</label>
							<input class="login name-field" id="organizationname" name="organizationname" type="text" placeholder="Enter Organization Name">
							<div id="organizationname-error" class="fail"></div>
						</div> <!-- /field -->

						<div class="field">
							<label for="password">Password:</label>
							<input type="password" id="password" name="password" value="" onkeyup="checkPasswordStrength()" placeholder="Password" class="login password-field"/>
							<div id="password-strength-status"></div>
						</div> <!-- /password -->

						<div class="field">
							<label for="confirmpassword">Confirm Password:</label>
							<input type="password" id="confirmpassword" name="confirmpassword" value="" placeholder="Confirm Password" class="login password-field"/>
						</div> <!-- /password -->
                        <div class="next_step_btn">
                            <button type="button" class="button btn btn-success btn-large" id="idnext">Next</button>
                        </div>
                        <div class="card-footer text-center">
                            <div class="small"><a href="login.php">Have an account? Go to login</a></div>
                        </div>
						
					</div> <!-- /login-fields -->
					
                    <div class="terms_content">
                        <div class="terms_of_content">
                        <h1>Terms of Service</h1>
									<b>
									THIS AGREEMENT IS BETWEEN ContentShare LIMITED, A PRIVATE COMPANY LIMITED BY SHARES
INCORPORATED IN ENGLAND AND WALES WITH COMPANY NUMBER 12999075 AND WHOSE
REGISTERED OFFICE IS AT 152 CITY ROAD, CITY ROAD, LONDON, EC1V 2NX (“ContentShare”) AND
YOU. IF YOU ARE ENTERING INTO THIS AGREEMENT ON BEHALF OF A COMPANY OR OTHER ENTITY,
YOU REPRESENT THAT YOU ARE THE individual, EMPLOYEE OR AGENT OF SUCH COMPANY (OR
OTHER ENTITY) AND YOU HAVE THE AUTHORITY TO ENTER INTO THIS AGREEMENT as the individual
or ON BEHALF OF SUCH COMPANY (OR OTHER ENTITY).

									</b>
									<b>
									BY CLICKING ON THE “I accept the terms of this agreement” BUTTON BELOW, YOU ACKNOWLEDGE
AND AGREE THAT YOU HAVE READ ALL OF THE TERMS AND CONDITIONS SET FORTH BELOW,
UNDERSTAND ALL OF THE TERMS AND CONDITIONS OF THIS AGREEMENT, AND AGREE TO BE
BOUND BY ALL OF THE TERMS AND CONDITIONS OF THIS AGREEMENT.
									</b>
									<b>
									IF YOU DO NOT AGREE TO ANY OF THE TERMS AND CONDITIONS OF THIS AGREEMENT,
ContentShare IS UNWILLING TO LICENSE THE SOFTWARE TO YOU, AND YOU MUST CLICK ON THE
“Cancel” BUTTON BELOW.
									</b>
									<b>
									THE “EFFECTIVE DATE” OF THIS AGREEMENT IS THE DATE UPON WHICH YOU CLICK THE “I accept the
terms of this agreement” BUTTON BELOW. FOR THE PURPOSE OF THIS AGREEMENT, YOU AND, IF
APPLICABLE, SUCH COMPANY (OR OTHER ENTITY) CONSTITUTES “YOU”.
									</b>
									<ul>	
										<li>
											<strong>Background.</strong> ContentShare develops, maintains, provides and operates a software solution
which is hosted on its website and through one or more applications for smart phones. In
this Agreement, “<i>Software</i>” means (a) the object code version of the computer program and
services hosted on the ContentShare website or via an application for smart phones
published by ContentShare from time to time, (b) the documentation accompanying the
computer program, and (c) any updates of such program and documentation. You wish to
use the Software.
										</li>
										<li><strong>Usage.</strong> You have agreed to use the Software on a per-user basis, subject to the terms and
conditions of this Agreement, ContentShare grants to You a non-exclusive, revocable,
non-transferable, usage of the Software from any device that is controlled by You subject to
fair usage policy.</li>
										<li>
											<strong>Usage Restrictions.</strong> Unless expressly otherwise set forth in this Agreement, You will not:
(a) modify, translate, copy or create derivative works of the Software; (b) decompile, reverse
engineer or reverse assemble any portion of the Software or attempt to discover any source
code or underlying ideas or algorithms of the Software; (c) sell, assign, sublicense, rent,
lease, loan, provide, distribute or otherwise transfer all or any portion of the Software; (d)
remove or alter any trademark, logo, copyright or other proprietary notices associated with
the Software; (e) exceed the capacity or concurrent user limitations for the Software license
purchased by You; (f) circumvent or attempt to circumvent any methods employed by
ContentShare to control access to the components, features or functions of the Software;
and (g) cause or permit any other party to do any of the foregoing. There are no implied
licenses in this Agreement, and ContentShare reserves all rights not expressly granted under
this Agreement.

										</li>
										<li>
											<strong>Ownership.</strong> As between the parties and subject to the grants under this Agreement,
ContentShare holds all right, tle and interest in and to the Software. Any and all patents,
copyrights, moral rights, trademarks, trade secrets and any other form of intellectual
property rights recognised in any jurisdiction, including applications and registrations for any
of the foregoing (collectively, “<i>Intellectual Property Rights</i>”) embodied therein shall remain
at all times the property of ContentShare.
										</li>
										<li>
											<strong>Payment Procedures.</strong> Usage of the Software is free subject to fair usage conditions unless
you have purchased an in application subscription, as such the subscription fees for the use
of the Software will be due and payable. All in-application purchases must be paid for at me
of purchase and are non refundable.

										</li>
										<li>
											<strong>Audit.</strong> ContentShare shall have the right to audit Your compliance with the terms of this
Agreement and the use restrictions on the Software, including the restriction on the number
of authorised users with access to the Software, as applicable. You agree to cooperate with
ContentShare in order to facilitate any such audit.

										</li>
										<li>
											<strong>Nondisclosure.</strong> “<i>Conﬁdential Information</i>” means all information disclosed (whether in oral, written, or other tangible or intangible form) by ContentShare to You concerning or related to this Agreement or ContentShare (whether before, on or after the Eﬀective Date) which You know or should know, given the facts and circumstances surrounding the disclosure of the information to You, is conﬁdential information of ContentShare, including, but not limited to, the Software. You will, during the term of this Agreement, and thereaGer maintain in conﬁdence the Conﬁdential Information and will not use such Conﬁdential Information except as expressly permitted herein. You will use the same degree of care in protecting the Conﬁdential Information as You use to protect Your own conﬁdential information from unauthorized use or disclosure, but in no event less than reasonable care. In addition, You: (a) will not reproduce Conﬁdential Information, in any form, except as required to accomplish Your obligations under this Agreement; and (b) will only disclose Conﬁdential Information to Your employees and consultants who have a need to know such Conﬁdential Information in order to perform their duties under this Agreement and if such employees and consultants have executed a non-disclosure agreement with You with terms no less restrictive than the non-disclosure obligations contained in this section. Conﬁdential Information will not include information that: (i) is in or enters the public domain without breach of this Agreement through no fault of You; (ii) You can reasonably demonstrate was in Your possession prior to ﬁrst receiving it from ContentShare; (iii) You can demonstrate was developed by You independently and without use of or reference to the Conﬁdential Information; or (iv) You receive from a third party without restriction on disclosure and without breach of a nondisclosure obligation. Notwithstanding any terms to the contrary in this Agreement, any suggestions, comments or other feedback provided by You to ContentShare with respect to the Software (collectively, “<i>Feedback</i>”) will constitute Conﬁdential Information. Further, ContentShare will be free to use, disclose, reproduce, license and otherwise distribute, and exploit the Feedback provided to it as it sees ﬁt, entirely without obligation or restriction of any kind on account of Intellectual Property Rights or otherwise.
										</li>
										<li>
											<strong>Software is available “As-Is”.</strong> The Software is provided “As-Is”, at your own risk, without
express or implied warranty or condition of any kind. See Secon 9. Disclaimer below.
										</li>
										<li>
											<strong>Disclaimer.</strong> THE SOFTWARE AND SERVICES ARE PROVIDED ON AN “AS IS” OR “AS AVAILABLE”
											BASIS WITHOUT ANY REPRESENTATIONS, WARRANTIES, COVENANTS OR CONDITIONS OF
											ANY KIND. ContentShare DOES NOT WARRANT THAT ANY OF THE SOFTWARE OR SERVICES
											WILL BE FREE FROM ALL BUGS, ERRORS, OR OMISSIONS. ContentShare DISCLAIMS ANY AND
											ALL OTHER WARRANTIES AND REPRESENTATIONS (EXPRESS OR IMPLIED, ORAL OR WRITTEN)
											WITH RESPECT TO THE SOFTWARE AND SERVICES WHETHER ALLEGED TO ARISE BY
											OPERATION OF LAW, BY REASON OF CUSTOM OR USAGE IN THE TRADE, BY COURSE OF
											DEALING OR OTHERWISE, INCLUDING ANY AND ALL (A) WARRANTIES OF MERCHANTABILITY,
											(B) WARRANTIES OF FITNESS OR SUITABILITY FOR ANY PURPOSE (WHETHER OR NOT
											ContentShare KNOWS, HAS REASON TO KNOW, HAS BEEN ADVISED, OR IS OTHERWISE
											AWARE OF ANY SUCH PURPOSE), AND (C) WARRANTIES OF NONINFRINGEMENT OR
											CONDITION OF TITLE.
										</li>
										<li>
											<strong>Limitation of Liability.</strong> IN NO EVENT WILL ContentShare BE LIABLE TO YOU OR ANY THIRD PARTY FOR ANY LOSS OF PROFITS, LOSS OF USE, LOSS OF REVENUE, LOSS OF GOODWILL,
 
 ANY INTERRUPTION OF BUSINESS, OR FOR ANY INDIRECT, SPECIAL, INCIDENTAL, EXEMPLARY, PUNITIVE OR CONSEQUENTIAL DAMAGES OF ANY KIND ARISING OUT OF OR IN CONNECTION WITH THIS AGREEMENT OR THE SOFTWARE, REGARDLESS OF THE FORM OF ACTION, WHETHER IN CONTRACT, TORT, STRICT LIABILITY OR OTHERWISE, EVEN IF ContentShare HAS BEEN ADVISED OR IS OTHERWISE AWARE OF THE POSSIBILITY OF SUCH DAMAGES. EXCEPT FOR ANY ACTS OF FRAUD, GROSS NEGLIGENCE OR WILLFUL MISCONDUCT, IN NO EVENT will ContentShare’s TOTAL LIABILITY ARISING OUT OF OR RELATED TO THIS AGREEMENT EXCEED
 £50.00, if any, UNDER THIS AGREEMENT. MULTIPLE CLAIMS WILL NOT EXPAND THIS LIMITATION. SOME JURISDICTIONS DO NOT ALLOW THE LIMITATION OR EXCLUSION OF IMPLIED WARRANTIES OR LIABILITY FOR INCIDENTAL OR CONSEQUENTIAL DAMAGES, AND SECTIONS 8, 9 AND 11 WILL NOT APPLY ONLY TO THE EXTENT THAT APPLICABLE LAW REQUIRES LIABILITY NOTWITHSTANDING THE LIMITATIONS OR EXCLUSIONS THEREIN. NOTHING IN THIS SECTION SHALL EXCLUDE LIABILITY FOR (I) DEATH OR PERSONAL INJURY CAUSED BY THE NEGLIGENCE OF ContentShare, ITS OFFICERS, EMPLOYEES, CONTRACTORS OR AGENTS (II) FRAUD OR FRAUDULENT MISREPRESENTATION OR (III) ANY OTHER LIABILITY WHICH MAY NOT BE EXCLUDED BY LAW.
 
										</li>
										<li>
											<strong>Third Party Suppliers.</strong> The Software may include software or other code distributed under
											license from third party suppliers or may contain open source software. You acknowledge
											that such suppliers disclaim and make no representation or warranty with respect to the
											Software or any portion thereof and ContentShare assumes no liability for any claim that
											may arise with respect to the Software or Your use or inability to use the same.
										</li>
										<li>
											<strong>Term and Termination.</strong> If You have made an in-applicaon purchase to use the Software, this
											Agreement will remain in effect from the Effective Date for the duration of the subscription
											period determined by the applicable order submitted by You and accepted by ContentShare,
											unless otherwise terminated in accordance with this Section 12; provided, however, that the
											term will automatically renew annually, at the then-current standard terms and condions,
											upon each anniversary of the initial Effective Date, unless either party notifies the other in
											writing of its intent to terminate at least 30 (thirty) days prior to the termination of the
											then-current subscription period. For free users of the Software there is no defined term for
											the usage of the Software, subject to fair usage policy.
											
											<p>
											Without prejudice to any other rights, ContentShare may terminate this Agreement if You do not
abide by the terms and conditions contained herein. Upon expiration or termination of this
Agreement: (a) all rights granted to You under this Agreement will immediately cease; and (b) You will
promptly provide ContentShare with all Confidential Information then in Your possession or destroy all
copies of such Confidential Information, at ContentShare’s sole discretion and direction. In addition to
all definitions and this sentence, the following sections will survive any termination or expiration of
this Agreement: 3, 4, 6, 7, 9, 10 and 12-18.

											</p>
										</li>
										<li>
											<strong>Governing Law; Venue.</strong> The Agreement and the validity, interpretation and operation hereof
shall be governed by the laws of England and Wales, and the courts of England and Wales
have exclusive jurisdiction to settle any claim or dispute arising out of or in connection with
this Agreement. The parties hereby irrevocably and unconditionally consent and submit to
the exclusive jurisdiction of such courts over any suit, acon or proceeding arising out of this
Agreement.
										</li>
										<li>
											<strong>English Language.</strong> It is the express wish of the parties that this Agreement and all related
documents be drawn up in English.
										</li>
										<li>
											<strong>Attorneys' Fees.</strong> In any action or proceeding to enforce rights under this Agreement, the
prevailing party will be entitled to recover costs and reasonable attorneys' fees.
										</li>
										<li>
											<strong>U.S. Government End Users.</strong> The Software and related documentation are "Commercial
Items," as that term is defined at 48 C.F.R. §2.101, consisting of "Commercial Computer
Software" and "Commercial Computer Software Documentation," as such terms are used in
48 C.F.R. §12.212 or 48 C.F.R. §227.7202, as applicable. Consistent with 48 C.F.R. §12.212 and
48 C.F.R. §§227.7202-1 through 227.7202-4, as applicable, the Software and related
documentation are being provided to U.S. Government end users (a) only as a Commercial
Item, and (b) with only those rights as are granted to all other end users pursuant to the
terms and conditions of this Agreement.
										</li>
										<li>
											<strong>Software Use and Updates.</strong> ContentShare reserves the right to update versions of the
Software without notification. Also, the Software will communicate with You for the purpose
of ensuring that you are using the Software with a valid license that ContentShare has
created and directly provided to you. This process does not collect any proprietary nor
personal information. ContentShare shall not provide any of the information it gathers in
connecon with this process to any third party, except (i) as may be required by law or legal
process or (ii) to enforce compliance with the license requirement described.
										</li>
										<li>
											<strong>User Conduct.</strong> You understand that all information, data, text, software, music, sound,
photographs, graphics, video, messages, tags, or other materials ("<strong>Content</strong>"), whether
publicly posted or privately transmitted, are the sole responsibility of the person from whom
such Content originated. This means that You, and not ContentShare, are entirely responsible
for all Content that you upload, post, email, transmit or otherwise make available via the
Software. ContentShare does not control the Content posted via the Software and, as such,
does not guarantee the accuracy, integrity or quality of such Content. Under no
circumstances will ContentShare be liable in any way for any Content, including, but not
limited to, any errors or omissions in any Content, or any loss or damage of any kind incurred
as a result of the use of any Content posted, emailed, transmitted or otherwise made
available via the Software.
											
											<p>
												You agree to not use the Software and services to:</p>
												<ol>
													<li>upload, post, email, transmit, or otherwise make available any Content that is unlawful,
harmful, threatening, abusive, harassing, tortious, defamatory, unlawfully pornographic,
vulgar, obscene, libelous, invasive of another's privacy, hateful, incites or encourages
terrorism, or is racially, ethnically, or otherwise objectionable;</li>
													<li>harm minors in any way;</li>
													<li>impersonate any person or entity or otherwise misrepresent your affiliation with a person or
entity;</li>
													<li>
													forge headers or otherwise manipulate idenfiers in order to disguise the origin of any
Content transmitted through the Software;
													</li>
													<li>
														upload, post, email, transmit, or otherwise make available any Content that you do not have
	a right to make available under any law or under contractual or fiduciary relationships (such
	as inside information, proprietary and confidential information learned or disclosed as part
	of employment relationships or under nondisclosure agreements);
													</li>
													<li>
														upload, post, email, transmit or otherwise make available any Content that infringes any
	patent, trademark, trade secret, copyright or other proprietary rights ("<strong>Rights</strong>") of any party;
													</li>
													<li>
													upload, post, email, transmit, or otherwise make available any unsolicited or unauthorized
advertising, promotional materials, "junk mail," "spam," "chain letters," "pyramid schemes,"
or any other form of solicitation, except in those areas (such as shopping) that are
designated for such purpose;

													</li>
													<li>
													upload, post, email, transmit, or otherwise make available any material that contains
software viruses or any other computer code, files or programs designed to interrupt,
destroy or limit the functionality of any computer software or hardware or
telecommunications equipment;
ContentShare reserves the right to delete or block access to any Content at any time in its sole
discretion if it receives any notices or otherwise believes that such Content may be in violaon of
applicable law or this Agreement or may otherwise violate the rights of, or cause any harm or liability
of any kind to, ContentShare or any third party.

													</li>
												</ol>
										</li>
										<li>
											<strong>Your Content.</strong> You acknowledge that ContentShare does not guarantee that any Content
transmitted through the Software will be secure. You acknowledge that users can screenshot
and otherwise copy Content provided to them. You further acknowledge that it is your
responsibility to ensure that Content is only provided to those persons you intend to receive
it and that it is your responsibility to manage all security settings. You acknowledge and
agree that ContentShare shall not be responsible for any dissemination of Content to persons
or the copying or retention of any Content by any person regardless of how such person
managed to receive, copy of retain such Content.

										</li>
										<li>
											<strong>Tracking Content.</strong> You acknowledge that Content transmitted through the Software may be
tracked (at the option of the sender of such Content) using geo-location technology. You may
disable the geo-location features on your device through the settings menu. If the recipient
of Content disables geo-location features, the sender of Content will receive the IP address
of the device through which the recipient accesses the Content. Where Content is tracked,
the recipient of such Content will receive a message warning of such tracking prior to
opening the Content. By using the Software, you agree to such tracking and consent to the
transmission of tracking information (whether derived from geo-location technology or the
IP address of the device through which you access the Software) to the sender of such
Content.

										</li>
										<li>
											<strong>Your Responsibilities.</strong> You, and not ContentShare, are responsible for maintaining and
protecting all of your Content. ContentShare will not be liable for any loss or corruption of
your Content, or for any costs or expenses associated with backing up or restoring any of
your Content. You understand that ContentShare uses third party billing and web platform
services and that ContentShare does not warranty their applicable software and services.
										</li>
										<li>
											<strong>Miscellaneous.</strong> This Agreement is the entire agreement of the parties regarding the subject
matter hereof, superseding all other agreements between them, whether oral or written,
regarding the subject matter hereof.

										</li>
									</ul>
									<p>
									You may not transfer Your rights under this Agreement to any third party. ContentShare may freely
transfer, assign or delegate this Agreement or its rights and duties under this Agreement.
									</p>
									<p>
									Subject to the foregoing, this Agreement will be binding upon and will inure to the benefit of the
parties and their respective representatives, heirs, administrators, successors and permitted assigns.
									</p>
									<p>
										If any provision of this Agreement is invalid, illegal, or incapable of being enforced by any rule of law
	or public policy, all other provisions of this Agreement will nonetheless remain in full force and effect
	so long as the economic or legal substance of the transactions contemplated by this Agreement is not
	affected in any manner adverse to any party. Upon such determination that any provision is invalid,
	illegal, or incapable of being enforced, the parties will negotiate in good faith to modify this
	Agreement so as to effect the original intent of the parties as closely as possible in an acceptable
	manner to the end that the transactions contemplated hereby are fulfilled.
									</p>
									<p>
									Any notice, demand or communication required or permitted to be given by any provision of this
Agreement will be deemed to have been sufficiently given or served for all purposes if: (a) delivered
personally; (b) deposited with a pre-paid messenger, express or air courier or similar courier; or
(c) transmitted by telecopier, facsimile, email or other communication equipment that transmits a
facsimile of the notice to like equipment that receives and reproduces such notice. Notices will be
deemed to have been received (i) in the case of personal delivery, upon receipt, (ii) in the case of
messenger, express or air courier or similar courier, two days after being deposited, and (iii) in the case
of telecopier, facsimile, email or other communication equipment, the day of receipt as evidenced by
a telecopier, facsimile, email or similar communication equipment confirmation statement.
									</p>    
                            <input type="checkbox" id="myCheck">
                            <label for="myCheck">I accept the terms of this agreement</label> 
                        </div>

                        <div class="login-actions loginButton">
                            <button type="submit" class="button btn btn-success btn-large" name="addnew" id="create" disabled>Create Account</button>
                        </div>	
                    </div>

				</form>
				
				
			</div>
		</div>		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->
<script>
	function checkPasswordStrength() {
            var number = /([0-9])/;
            var alphabets = /([a-zA-Z])/;
            var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
            if ($('#password').val().length < 6) {
                $('#password-strength-status').removeClass();
                $('#password-strength-status').addClass('weak-password');
                $('#password-strength-status').html("Weak (should be atleast 6 characters.)");
                $("#create").prop('disabled', true);
            } else {
                if ($('#password').val().match(number) && $('#password').val().match(alphabets) && $('#password').val().match(special_characters)) {
                    $('#password-strength-status').removeClass();
                    $('#password-strength-status').addClass('strong-password');
                    $('#password-strength-status').html("Strong");
                    $("#create").prop('disabled', false);
                } else {
                    $('#password-strength-status').removeClass();
                    $('#password-strength-status').addClass('medium-password');
                    $('#password-strength-status').html("Medium (should include alphabets, numbers and special characters.)");
                    $("#create").prop('disabled', true);
                }
            }
        }

         $('#create').click(function() {
            $(".loader").show();
         });

</script>

</body>
</html>