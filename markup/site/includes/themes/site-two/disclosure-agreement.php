<?php
// Require common functionality
if ( ! defined('ENVIRONMENT') )
{
	require_once(str_repeat('../', 3) . 'includes/common.php');
}

$page_data = array(
	'meta_title' => 'Disclosure Agreement | Top Home Inspections | Columbus, Ohio',
	'meta_description' => 'Let Top Home Inspections evaluate the condition of your current or soon-to-be home to make you aware of existing and potential issues. We&srquo;re qualified, high integrity, and Columbus local. Call us now at (614) 123-4567',
	'meta_keywords' => 'home, inspection, columbus, ohio, building, professional, thorough, report, issues, roof, insulation, plumbing, foundation, electrical',
	'site_name' => 'Top Home Inspections | Columbus, Ohio',
);
?><!DOCTYPE html>
<!--[if lt IE 7 ]><html class="loading no-js ie lt-ie10 lt-ie9 lt-ie8 lt-ie7 ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="loading no-js ie lt-ie10 lt-ie9 lt-ie8 ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="loading no-js ie lt-ie10 lt-ie9 ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="loading no-js ie lt-ie10 ie9" lang="en"> <![endif]-->
<!--[if (gte IE 10)|!(IE)]><!--><html class="loading no-js" lang="en"> <!--<![endif]-->
<head>

	<?php
	// Head common tags and resources
	include(THEME_PATH . 'includes/common/head.php');
	?>
	
</head>
<body class="responsive-menu-liner">
<?php
// Body Prepend
include(THEME_PATH . 'includes/common/body.prepend.php');
?>


<div class="body-liner">


<?php require_once(THEME_PATH . 'includes/common/header.php'); ?>



<div class="band-wrap">
<div class="band padding-tbl content grid-gutter">
<div class="band-liner">

	<section class="content">
		<div class="tab-title">
			<h2>Disclosure Agreement</h2>
			<h3>Setting and meeting everyone's expectations</h3>
		</div>
		<p>This is the plain English agreement that will need to be signed prior to or upon completion of the inspection. Inspection rates can be <a href="<?php echo theme_nav_url('#inspection-rates'); ?>">reviewed here</a>.</p>
		
		<hr>
		
		<form action="<?php echo theme_url('_process'); ?>" method="post" novalidate="novalidate" class="agreement-form"><!--enctype="multipart/form-data"-->
			<input type="hidden" name="action" value="disclosure">
			
			<fieldset>
			
				<div class="columns grid grid-flush">
					<div class="column-row">
						<div class="column w100">
<p>This is an Agreement between you, the undersigned Client, and us, the Inspector, pertaining to our inspection of the Property at:</p>

<p><textarea name="property_address" placeholder="Property address&hellip;" rows="3" class="w100"></textarea></p>

<p>The terms below govern this Agreement.</p>

<p>1. You will pay us $ <input type="text" name="inspection_fee" placeholder="" size="7"> for our inspection.  You have paid us a deposit of $ <input type="text" name="inspection_deposit" placeholder="" size="7">.</p>

<p>2. We will perform a visual inspection of the home/building and provide you with a written report identifying the defects that we (1) observed and (2) deemed material.  The report is only supplementary to the seller’s disclosure.</p>

<p>3. Unless otherwise noted in this Agreement or it is not possible, we will perform the inspection in accordance with the current Standards of Practice (SOP’s) of the International Association of Certified Home Inspectors (“InterNACHI”) posted at <a href="http://www.nachi.org/sop.htm" target="_blank">http://www.nachi.org/sop.htm</a>.  If your jurisdiction has adopted mandatory standards that differ from InterNACHI’s SOP’s, we will perform the inspection in accordance with your jurisdiction’s standards.  You understand that InterNACHI’s SOP’s contain limitations, exceptions, and exclusions.  You understand that InterNACHI is not a party to this Agreement, has no control over us, and does not supervise us.</p>

<p>4. Unless otherwise indicated in writing, we will NOT test for the presence of radon – a colorless, odorless, radioactive gas that may be harmful to humans.  Unless otherwise indicated in writing, we will not test for mold.  Unless otherwise indicated in writing, we will not test for compliance with applicable building codes or for the presence of or for any potential dangers arising from the presence of asbestos, lead paint, formaldehyde, soil contamination, and other environmental hazards or violations.  If any structure or portion of any structure you want us to inspect is a log home, log structure or includes similar log construction, you understand that such structures have unique characteristics that may make it impossible for us to inspect and evaluate them.  Therefore, the scope of our inspection will not include decay of the interior of logs in log walls, log foundations or roofs, or similar defects.</p>

<p>5. Our inspection and report are for your use only.  You give us permission to discuss our observations with real estate agents, owners, repair persons, or other interested parties. You will be the sole owner of the report and all rights to it.  We are not responsible for use or misinterpretation by third parties, and third parties who rely on it in any way do so at their own risk and release us (including employees and business entities) from any liability whatsoever. If you or any person acting on your behalf provide the report to a third party who then sues you and/or us, you release us for any liability agree to pay our costs and legal fees in defending any action naming us. Our inspection and report are in no way a guarantee or warranty, express or implied, regarding the future use, operability, habitability or suitability of the home/building or its components. We disclaim all warranties, express or implied, to the fullest extent allowed by law.</p>

<p>6. We assume no liability for the cost of repair or replacement of unreported defects or deficiencies either current or arising in the future. You agree that in all cases our liability shall be limited to liquidated damages in an amount not greater than the fee you paid us.  You waive any claim for consequential, exemplary, special or incidental damages or for the loss of the use of the home/building.  You acknowledge that the liquidated damages are not a penalty, but that we intend them to (i) reflect the fact that actual damages may be difficult and impractical to ascertain; (ii) allocate risk between us; and (iii) enable us to perform the inspection for the agreed upon fee.</p>

<p>7. We do not perform engineering, architectural, plumbing, or any other job function requiring an occupational license in the jurisdiction where the property is located.  If we hold a valid occupational license, we may inform you of this and you may hire us to perform additional functions. Any agreement for such additional services shall be in a separate writing.</p>

<p>8. If you believe you have a claim against us, you agree to provide us with the following: (1) written notification of adverse conditions within seven days of discovery; and (2) immediate access to the premises.  Failure to comply with these conditions releases us from liability.</p>

<p>9. You agree that any litigation arising out of this Agreement shall be filed only in the Court having jurisdiction in the County where we have our principal place of business.  If you fail to prove any claim against us, you agree to pay all our legal costs, expenses and fees incurred in defending that claim. You agree that any legal action against InterNACHI itself, allegedly arising out of this Agreement or our membership in InterNACHI, must be brought only in the District Court of Boulder County, Colorado.  Before bringing any such action, you must provide InterNACHI with 30 days’ written notice of the nature of the claim.  In any action against us or InterNACHI, you waive trial by jury.</p>

<p>10. If a court declares any provision of this Agreement invalid, the remaining provisions remain in effect.  This Agreement represents our entire agreement; there are no terms or promises other than those set forth herein.  No statement or promise by us shall be binding unless reduced to writing and signed by one of our authorized officers.  Any modification of this Agreement must be in writing and signed by you and by one of our authorized officers. This Agreement shall be binding upon and enforceable by the parties and their heirs, executors, administrators, successors and assignees.  You will have no cause of action against us after one year from the date of the inspection.</p>

<p>11. Payment of the inspection fee (less any deposit noted above) is due when we complete the inspection.  You agree to pay all costs and attorney’s fees incurred in collecting the fee owed to us.  If the Client is a corporation, LLC, or similar entity, you personally guarantee payment of the fee.</p>

<p>12. If you request a re-inspection, the re-inspection is subject to the terms of this Agreement.</p>

<p>13. You may not assign this Agreement.</p>

<p>14. If a court finds any term of this Agreement ambiguous or that it otherwise requires judicial interpretation, the court shall not construe that term against us by reason of the rule that any ambiguity in a document is construed against the party drafting it.  You had the opportunity to consult qualified counsel before signing this Agreement.</p>

<p>15. If there is more than one Client, you are signing on behalf of all of them, and you represent that you are authorized to do so.</p>

<p class="padding-tb3">By submitting this form, you agree to the following:<br>
I HAVE CAREFULLY READ THIS AGREEMENT.  I AGREE TO IT AND ACKNOWLEDGE RECEIVING A COPY OF IT.</p>

						</div>
					</div>
					<div class="column-row">
						<div class="column w33">
							<label>Client 1 Name</label>
							<input type="text" name="client1_name" placeholder="Client Name" class="w100">
						</div>
						<div class="column w33">
							<label>Client 1 Email</label>
							<input type="email" name="client1_email" placeholder="Client Email" class="w100">
						</div>
						<div class="column w33">
							<label>Date</label>
							<input type="date" name="client1_date" value="<?php echo date('Y-m-d', $now_time); ?>" placeholder="mm/dd/yyyy" class="w100">
						</div>
					</div>
					<div class="column-row">
						<div class="column w33">
							<label>Client 2 Name</label>
							<input type="text" name="client2_name" placeholder="Client Name" class="w100">
						</div>
						<div class="column w33">
							<label>Client 2 Email</label>
							<input type="email" name="client2_email" placeholder="Client Email" class="w100">
						</div>
						<div class="column w33">
							<label>Date</label>
							<input type="date" name="client2_date" value="<?php echo date('Y-m-d', $now_time); ?>" placeholder="mm/dd/yyyy" class="w100">
						</div>
					</div>
					<div class="column-row margin-t3">
						<div class="column w100">
							<input type="submit" value="Submit" class="w100 padding-tb2 button button-inverse">
						</div>
					</div>
				</div>
				
			</fieldset>
			
		</form>

	</section>
	
</div>
</div>
</div>



<?php require_once(THEME_PATH . 'includes/common/footer.php'); ?>

</div>
<!-- /body-liner -->


<?php
// Body Append
include(THEME_PATH . 'includes/common/body.append.php');
?>
</body>
</html>