<?php
// Require common functionality
if ( ! defined('ENVIRONMENT') )
{
	require_once(str_repeat('../', 1) . 'includes/common.php');
}
?><!DOCTYPE html>
<!--[if lt IE 7 ]><html class="no-js ie lt-ie10 lt-ie9 lt-ie8 lt-ie7 ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="no-js ie lt-ie10 lt-ie9 lt-ie8 ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="no-js ie lt-ie10 lt-ie9 ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js ie lt-ie10 ie9" lang="en"> <![endif]-->
<!--[if (gte IE 10)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>

	<?php
	// Head common tags and resources
	include(THEMEPATH . 'common/head.php');
	?>
	
	<link rel="stylesheet" type="text/css" href="<?php echo cb_url(REDLOVE_ROOT . 'stylesheets/redlove/examples.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo cb_url('stylesheets/site.css'); ?>">
	
</head>
<body>
<?php
// Body Prepend
include(THEMEPATH . 'common/body.prepend.php');
?>

<div class="body-liner">

<?php
// Header
include(THEMEPATH . 'common/header.php');
?>

<div class="band-wrap">
<div class="band padding-tbm content">
<div class="band-liner">

	<section class="content">
	
	
<h1>Style Guide</h1>

<h2>Foundation</h2>

<h3 id="toc_foundation_typography">Typography</h3>

<h4>Headings</h4>

<?php
$code = <<< CODE
<div class="columns grid grid-flush">
	<div class="column-row">
		<div class="column w40">
			<h1>Heading 1</h1>
			<h2>Heading 2</h2>
			<h3>Heading 3</h3>
			<h4>Heading 4</h4>
			<h5>Heading 5</h5>
			<h6>Heading 6</h6>
		</div>
		<div class="column w60">
			<h2>Heading 2</h2>
			<p>Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text.</p>
			<h3>Heading 3</h3>
			<p>Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text.</p>
			<h4>Heading 4</h4>
			<p>Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text.</p>
			<h5>Heading 5</h5>
			<p>Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text.</p>
		</div>
	</div>
</div>
CODE;
output_code($code);
?>

<h4>Text</h4>

<?php
$code = <<< CODE
<h6>Lead Text</h6>
<p class="text-lead">Lead paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text.</p>

<h6>Drop cap and normal Text</h6>
<p><span class="text-dropcap">D</span>rop cap. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text.</p>

<h6>Meta Text</h6>
<p class="text-meta">Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text.</p>

<h6>Micro Text</h6>
<p class="text-micro">Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text.</p>

<h6>Dim Text</h6>
<p class="text-dim">Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text.</p>

<h6>Card Text</h6>
<p class="text-card">Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text. Paragraph of text.</p>
CODE;
output_code($code);
?>

<h4>Marks</h4>

<?php
$code = <<< CODE
<ul class="marks-list">
	<li>
		<code>b - </code> <b>Bold</b>
	</li>
	<li>
		<code>strong - </code> <strong>Strong</strong>
	</li>
	<li>
		<code>i - </code> <i>Italic</i>
	</li>
	<li>
		<code>em - </code> <em>Emphasized</em>
	</li>
	<li>
		<code>sup - </code> <sup>Superscript</sup>
	</li>
	<li>
		<code>sub - </code> <sub>Subscript</sub>
	</li>
	<li>
		<code>del - </code> <del>Deleted</del>
	</li>
	<li>
		<code>s - </code> <s>Strikethrough</s>
	</li>
	<li>
		<code>ins - </code> <ins>Inserted</ins>
	</li>
	<li>
		<code>kbd - </code> <kbd>cd</kbd>
	</li>
	<li>
		<code>code - </code> <code>&lt;section&gt;Text&lt;/section&gt;</code>
	</li>
	<li>
		<code>pre - </code> <pre>&lt;p&gt;Text&hellip;&lt;/p&gt;</pre>
	</li>
	<li>
		<code>var - </code> <var>y</var> = <var>m</var><var>x</var> + <var>b</var>
	</li>
	<li>
		<code>samp - </code> <samp>Sample output.</samp>
	</li>
	<li>
		<code>a - </code> <a href="#">Link</a>
	</li>
	<li>
		<code>mark - </code> A <mark>highlighted</mark> mark
	</li>
	<li>
		<code>abbr - </code> An abbreviation like <abbr title="feet">ft.</abbr> or <abbr class="initialism" title="Ohio">Oh</abbr>
	</li>
	<li>
		<code>hr - </code>
		<hr>
		<hr class="default">
		<hr class="default section">
		<hr class="default section center w60">
	</li>
	<li>
		<code>address - </code> 
		<address>
		  <strong>Twitter, Inc.</strong><br>
		  795 Folsom Ave, Suite 600<br>
		  San Francisco, CA 94107<br>
		  <abbr title="Phone">P:</abbr> (123) 456-7890 (address)
		</address>

		<address>
		  <strong>Full Name</strong><br>
		  <a href="mailto:#">first.last@example.com</a>
		</address>
	</li>
</ul>

<style type="text/css" media="all">
	.marks-list {
		display: inline-block;
		margin: 0;
		vertical-align: top;
		width: 100%;
	}
	.marks-list li {
		float: left;
		width: 45%;
	}
	.marks-list li:nth-child(2n+1) {
		clear: left;
	}
</style>
CODE;
output_code($code);
?>

<h4>Code</h4>

<?php
$code = <<< CODE
<pre class="code">&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;body&gt;
	&lt;script&gt;
	document.write("Hello World!");
	// Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.
	&lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;</pre>

<hr class="default">

<pre><code>&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;body&gt;
	&lt;script&gt;
	document.write("Hello World!");
	// Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.
	&lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>
CODE;
output_code($code);
?>

<h4>Quotes</h4>

<?php
$code = <<< CODE
<blockquote class="default">
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
	<footer>Someone famous in <cite title="Source Title">Source Title</cite></footer>
</blockquote>
CODE;
output_code($code);
?>

<h3 id="toc_foundation_lists">Lists</h3>

<?php
$code = <<< CODE
<div class="columns">
	<div class="column-row">
		<div class="column w25">
			<h4>Unordered List</h4>
			<ul>
				<li>List item
					<ul>
						<li>List item
							<ul>
								<li>List item</li>
							</ul>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		<div class="column w25">
			<h4>Square List</h4>
			<ul class="list-style-square">
				<li>List item
					<ul>
						<li>List item
							<ul>
								<li>List item</li>
							</ul>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		<div class="column w25">
			<h4>Circle List</h4>
			<ul class="list-style-circle">
				<li>List item
					<ul>
						<li>List item
							<ul>
								<li>List item</li>
							</ul>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		<div class="column w25">
			<h4>Disc List</h4>
			<ul class="list-style-disc">
				<li>List item
					<ul>
						<li>List item
							<ul>
								<li>List item</li>
							</ul>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<div class="column-row">
		<div class="column w25">
			<h4>Ordered List</h4>
			<ol>
				<li>List item
					<ol>
						<li>List item
							<ol>
								<li>List item
									<ol>
										<li>List item
											<ol>
												<li>List item</li>
											</ol>
										</li>
									</ol>
								</li>
							</ol>
						</li>
					</ol>
				</li>
			</ol>
		</div>
		<div class="column w25">
			<h4>No Style List</h4>
			<ul class="list-style-none">
				<li>List item
					<ul>
						<li>List item
							<ul>
								<li>List item</li>
							</ul>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		<div class="column w25">
			<h4>Vertical List</h4>
			<ul class="list-vertical">
				<li>List item</li>
				<li>List item</li>
				<li>List item</li>
			</ul>
		</div>
		<div class="column w25">
			<h4>Horizontal List</h4>
			<ul class="list-horizontal">
				<li>List item</li>
				<li>List item</li>
				<li>List item</li>
			</ul>
		</div>
		<div class="column w25">
			<h4>Inline List</h4>
			<ul class="list-inline">
				<li>List item</li>
				<li>List item</li>
				<li>List item</li>
			</ul>
		</div>
		<div class="column w100 clear-left">
			<h4>Definition List</h4>
			<dl>
				<dt>Definition lists</dt>
				<dd>A definition list is perfect for defining terms.</dd>
				<dt>Euismod</dt>
				<dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit.</dd>
				<dd>Donec id elit non mi porta gravida at eget metus.</dd>
				<dt>Malesuada porta</dt>
				<dd>Etiam porta sem malesuada magna mollis euismod.</dd>
			</dl>
		</div>
	</div>
</div>
CODE;
output_code($code);
?>

<h3 id="toc_foundation_tables">Tables</h3>

<?php
$code = <<< CODE
<div class="responsive-wrap">
	<table border="0" cellpadding="0" cellspacing="0" class="default">
		<caption>Table Caption</caption>
		<thead>
			<tr>
				<th>Table heading</th>
				<th>Table heading</th>
				<th>Table heading</th>
				<th>Table heading</th>
				<th>Table heading</th>
				<th>Table heading</th>
				<th>Table heading</th>
				<th>Table heading</th>
				<th>Table heading</th>
				<th>Table heading</th>
			</tr>
		</thead>
		<tbody class="zebra">
			<tr>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
			</tr>
			<tr>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
			</tr>
			<tr>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
			</tr>
			<tr>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
			</tr>
			<tr>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
				<td>Table cell</td>
			</tr>
		</tbody>
		<tfoot></tfoot>
	</table>
</div>
CODE;
output_code($code);
?>

<?php
$code = <<< CODE
<div class="responsive-wrap">
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="default text-left">
		<tbody>
			<tr>
				<th align="left" valign="top" scope="col" nowrap="nowrap">Date:</th>
				<td align="left" valign="top" nowrap="nowrap" width="100%">November 21, 2013</td>
			</tr>
			<tr>
				<th align="left" valign="top" scope="col" nowrap="nowrap">Church:</th>
				<td align="left" valign="top" nowrap="nowrap" width="100%">Church Name<br />
				Address Line 1<br />
				Address Line 2<br />
				City, State Zip</td>
			</tr>
		</tbody>
	</table>
	<h3>Invoice Details</h3>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="default text-left">
		<thead>
			<tr class="row">
				<th align="left" valign="top" scope="col">Item</th>
				<th align="right" valign="top" scope="col">Price</th>
				<th align="right" valign="top" scope="col">Quantity</th>
				<th align="right" valign="top" scope="col">Subtotal</th>
			</tr>
		</thead>
		
		<tbody>
			<tr>
				<th align="left" valign="top" colspan="4" scope="col">
					Event Participants
				</th>
			</tr>
			<tr class="row">
				<td align="left" valign="top">Children</td>
				<td align="right" valign="top">$80.00</td>
				<td align="right" valign="top">1</td>
				<td align="right" valign="top">$80.00</td>
			</tr>
			<tr class="row">
				<td align="left" valign="top">Teens</td>
				<td align="right" valign="top">$160.00</td>
				<td align="right" valign="top">10</td>
				<td align="right" valign="top">$1,600.00</td>
			</tr>
			<tr class="row">
				<td align="left" valign="top">Adult</td>
				<td align="right" valign="top">$160.00</td>
				<td align="right" valign="top">2</td>
				<td align="right" valign="top">$320.00</td>
			</tr>
		</tbody>
		
		<tbody>
			<tr>
				<th align="left" valign="top" colspan="4" scope="col">
					Event Lodging
				</th>
			</tr>
			<tr class="row">
				<td align="left" valign="top">Hotel room (5 person max. occupancy)</td>
				<td align="right" valign="top">$350.00</td>
				<td align="right" valign="top">3</td>
				<td align="right" valign="top">$1,050.00</td>
			</tr>
		</tbody>
		
		<tfoot>
			<tr>
				<th align="left" valign="top" colspan="4" scope="col">
					Total
				</th>
			</tr>
			<tr>
				<th align="right" valign="top" colspan="3" scope="row" class="normal">Discount</th>
				<td align="right" valign="top">($0.00)</td>
			</tr>
			<tr>
				<th align="right" valign="top" colspan="3" scope="row" class="normal">Subtotal</th>
				<td align="right" valign="top">$3,300.00</td>
			</tr>
			<tr>
				<th align="right" valign="top" colspan="3" scope="row" class="normal">Payment (11/12/2013)<br />
				<i>Notes: Deposit</i></th>
				<td align="right" valign="top">($100.00)</td>
			</tr>
			<tr>
				<th align="right" valign="top" colspan="3" scope="row">Balance</th>
				<td align="right" valign="top" class="total">$3,000.00</td>
			</tr>
		</tfoot>
		
	</table>
</div>
CODE;
output_code($code);
?>

<h3 id="toc_foundation_forms">Forms</h3>

<?php
$code = <<< CODE
<form action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
	
	<fieldset>
	
		<div class="columns">
			
			<legend>Form fields</legend>
			
			<div class="column-row">
				<div class="column w33">
					
					<div class="form-row">
						<div class="label">
							<label for="">Text input<em>*</em></label>
						</div>
						<div class="input">
							<input type="text" id="" name="" value="" autocomplete="off">
						</div>
					</div>
					
				</div>
				<div class="column w33">
					
					<div class="form-row">
						<div class="label">
							<label for="">Textarea</label>
						</div>
						<div class="input">
							<textarea name="" placeholder="Placeholder content&hellip;" id=""></textarea>
						</div>
					</div>
					
				</div>
				<div class="column w33">
					
					<div class="form-row">
						<div class="label">
							<label for="">Select</label>
						</div>
						<div class="input">
							<select name="" id="">
								<option value="">&mdash; Please select &mdash;</option>
								<option value="1">Option 1</option>
								<option value="2">Option 2</option>
								<option value="3">Option 3</option>
							</select>
						</div>
					</div>
					
				</div>
			</div>
			<div class="column-row">
				<div class="column w33">
					
					<div class="form-row">
						<div class="label">
							<label for="">Checkbox</label>
						</div>
						<div class="input">
							<input type="checkbox" name="" value=""> Checkbox input without label
							<br>
							<label>
								<input type="checkbox" name="" value=""> Checkbox input wrapped in label
							</label>
							<br>
							<label class="label-checkbox">
								<input type="checkbox" name="" value=""> Checkbox input wrapped in checkbox label
							</label>
						</div>
					</div>
					
				</div>
				<div class="column w33">
					
					<div class="form-row">
						<div class="label">
							<label for="">Radio</label>
						</div>
						<div class="input">
							<input type="radio" name="" value=""> Radio input without label
							<br>
							<label>
								<input type="radio" name="" value=""> Radio input wrapped in label
							</label>
							<br>
							<label class="label-radio">
								<input type="radio" name="" value=""> Radio input wrapped in radio label
							</label>
						</div>
					</div>
					
				</div>
				<div class="column w33">
					
					<div class="form-row">
						<div class="label">
							<label for="">File</label>
						</div>
						<div class="input">
							<input type="file" name="">
						</div>
					</div>
					
				</div>
			</div>
			<div class="column-row">
				
				<legend>Input buttons</legend>
				
				<div class="column w100">
					
					<div class="form-row">
						<div class="label"></div>
						<div class="input">
							<input type="submit" value="Submit input"><span class="ajax-loading hide"></span>
							<!-- Standard buttons -->
							<a href="#" class="button">Anchor button</a>
							<button>Button element</button>
							<input type="submit" value="Submit input">
							<input type="button" value="Button input">
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
	</fieldset>
	
</form>
CODE;
output_code($code);
?>

<?php
$code = <<< CODE
<form action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
	
	<fieldset>
		
		<legend>Default, stacked with no wrappers</legend>
		
		<label>Your email<em>*</em></label>
		<input type="text" placeholder="test@mail.com">
		
		<label>Reason for contacting</label>
		<select>
			<option>&mdash; Please select &mdash;</option>
			<option>Questions</option>
			<option>Quote</option>
			<option>Something Random</option>
		</select>
		
		<label>Message</label>
		<textarea placeholder="Your message&hellip;"></textarea>
		
		<label>Label above checkbox</label>
		<div class="input">
			<input type="checkbox"> Checkbox input <input type="checkbox"> Checkbox input <input type="checkbox"> Checkbox input
			
			<label class="label-checkbox">
				<input type="checkbox"> Checkbox input wrapped in checkbox label
			</label>
		</div>
		
		<input type="submit" value="Submit">
		
	</fieldset>
	
</form>
CODE;
output_code($code);
?>

<?php
$code = <<< CODE
<form action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
	
	<fieldset>
	
		<legend>form-row fields-inline</legend>
		
		<div class="form-row fields-inline">
			
			<label>Your email<em>*</em></label>
			<input type="text" placeholder="test@mail.com">
			
			<label>Reason for contacting</label>
			<select>
				<option>&mdash; Please select &mdash;</option>
				<option>Questions</option>
				<option>Quote</option>
				<option>Something Random</option>
			</select>
			
			<input type="submit" value="Submit" class="field_space-left">
			
		</div>
		
		<hr>
		
		<div class="form-row fields-inline">
			<label>Your email<em>*</em></label>
			<input type="text" placeholder="test@mail.com">
		</div>
		
		<div class="form-row fields-inline">
			<label>Reason for contacting</label>
			<select>
				<option>&mdash; Please select &mdash;</option>
				<option>Questions</option>
				<option>Quote</option>
				<option>Something Random</option>
			</select>
		</div>
		
		<div class="form-row fields-inline">
			<label>Message</label>
			<textarea placeholder="Your message&hellip;"></textarea>
		</div>
		
		<div class="form-row fields-inline">
			<label>Label above checkbox</label>
			<div class="input">
				<input type="checkbox"> Checkbox input <input type="checkbox"> Checkbox input <input type="checkbox"> Checkbox input
				
				<label class="label-checkbox">
					<input type="checkbox"> Checkbox input wrapped in checkbox label
				</label>
			</div>
		</div>
		
		<div class="form-row fields-inline">
			<div class="label"></div>
			<input type="submit" value="Submit">
		</div>
		
	</fieldset>
	
</form>
CODE;
output_code($code);
?>

<?php
$code = <<< CODE
<form action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
	
	<fieldset>
		
		<legend>form-float</legend>
		
		<div class="form-float">
			
			<div class="form-row">
				<label>Your email<em>*</em></label>
				<input type="text" placeholder="test@mail.com">
			</div>
			
			<div class="form-row">
				<label>Reason for contacting</label>
				<select>
					<option>&mdash; Please select &mdash;</option>
					<option>Questions</option>
					<option>Quote</option>
					<option>Something Random</option>
				</select>
			</div>
			
			<div class="form-row">
				<label>Message</label>
				<textarea placeholder="Your message&hellip;"></textarea>
			</div>
			
			<div class="form-row">
				<label>Label above checkbox</label>
				<div class="input">
					<input type="checkbox"> Checkbox input <input type="checkbox"> Checkbox input <input type="checkbox"> Checkbox input
					
					<label class="label-checkbox">
						<input type="checkbox"> Checkbox input wrapped in checkbox label
					</label>
				</div>
			</div>
			
			<div class="form-row">
				<div class="label"></div>
				<input type="submit" value="Submit">
			</div>
			
		</div>
		
	</fieldset>
	
</form>
CODE;
output_code($code);
?>

<?php
$code = <<< CODE
<form action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
	
	<fieldset>
		
		<legend>form-table</legend>
		
		<table class="form-table">
			<tbody>
				<tr>
					<td>
						<label>Your email<em>*</em></label>
					</td>
					<td>
						<input type="text" placeholder="test@mail.com">
					</td>
				</tr>
				<tr>
					<td>
						<label>Reason for contacting</label>
					</td>
					<td>
						<select>
							<option>&mdash; Please select &mdash;</option>
							<option>Questions</option>
							<option>Quote</option>
							<option>Something Random</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label>Message</label>
					</td>
					<td>
						<textarea placeholder="Your message&hellip;"></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<label>Label above checkbox</label>
					</td>
					<td>
						<div class="input">
							<input type="checkbox"> Checkbox input <input type="checkbox"> Checkbox input <input type="checkbox"> Checkbox input
							
							<label class="label-checkbox">
								<input type="checkbox"> Checkbox input wrapped in checkbox label
							</label>
						</div>
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input type="submit" value="Submit">
					</td>
				</tr>
			</tbody>
		</table>
		
	</fieldset>
	
</form>
CODE;
output_code($code);
?>

<?php
$code = <<< CODE
<form action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
	
	<fieldset>
	
		<legend>form-row columns</legend>
		
		<div class="form-row">
			<div class="column w50">
				<label for="">Your email</label>
				<input type="text" placeholder="test@mail.com" class="width-full">
			</div>
			<div class="column w50">
				<label for="">Your email</label>
				<input type="text" placeholder="test@mail.com" class="width-full">
			</div>
		</div>
		
		<hr>
		
		<div class="columns grid grid-flush">
			<div class="column-row">
				<div class="column w33">
					<label>Your email<em>*</em></label>
					<input type="text" placeholder="test@mail.com" class="width-full">
				</div>
				<div class="column w33">
					<label>Reason for contacting</label>
					<select class="width-full">
						<option>&mdash; Please select &mdash;</option>
						<option>Questions</option>
						<option>Quote</option>
						<option>Something Random</option>
					</select>
				</div>
				<div class="column w33">
					<div class="label">&nbsp;</div>
					<input type="submit" value="Submit" class="width-full">
				</div>
			</div>
		</div>
		
		<hr>
		
		<div class="columns grid grid-flush">
			<div class="column-row">
				<div class="column w50">
					<label>Your email<em>*</em></label>
					<input type="text" placeholder="test@mail.com" class="width-full">
				</div>
				<div class="column w50">
					<label>Reason for contacting</label>
					<select class="width-full">
						<option>&mdash; Please select &mdash;</option>
						<option>Questions</option>
						<option>Quote</option>
						<option>Something Random</option>
					</select>
				</div>
			</div>
			<div class="column-row">
				<div class="column w100">
					<label>Message</label>
					<textarea placeholder="Your message&hellip;" class="width-full"></textarea>
				</div>
			</div>
			<div class="column-row">
				<div class="column w100">
					<label class="label-checkbox field_space-top-half pull-right">
						<input type="checkbox"> Checkbox input wrapped in checkbox label
					</label>
					<input type="submit" value="Submit">
				</div>
			</div>
		</div>
		
		<hr>
		
		<div class="columns">
			
			<div class="column w50">
				
				<h3>Sign in</h3>
				
				<form action="" method="post" novalidate="novalidate"><!-- enctype="multipart/form-data"-->
					<fieldset>
						<label for="">Email<em>*</em></label>
						<input type="text" id="" name="" value="" placeholder="Email" />
						
						<label for="">Password<em>*</em></label>
						<input type="password" id="" name="" value="" placeholder="Password" />
						<a href="#">Forgot password?</a>
						
						<label class="input label-checkbox"><input type="checkbox" name="agree_to_terms" value="1" id="" /> Remember me</label>
						
						<input type="submit" value="Submit">
						
						<span class="ajax-loading hide"></span>
					</fieldset>
				</form>
				
			</div>
			
			<div class="column w50">
				
				<h3>Sign up</h3>
				
				<p>A paragraph of registration text.</p>
				<p><a href="#" class="button">Sign up now!</a></p>
				
			</div>
			
		</div>

	</fieldset>
	
</form>
CODE;
output_code($code);
?>

<?php
$code = <<< CODE
<form action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
	
	<fieldset>
		
		<legend>Hidden Input</legend>
		
		<div class="input_file-hide_wrap">
			<input type="file" name="directory_image" id="directory_image" class="input_file-hide_file" onchange="$(this).next().find('input[type=text]').val(this.value.substring(this.value.lastIndexOf('\\')+1));" />
			<div class="input_file-hide_fake">
				<input type="text" name="directory_image-text" value="">
				<input type="button" value="Browse">
			</div>
		</div>
		
	</fieldset>
	
</form>
CODE;
output_code($code);
?>

<?php
$code = <<< CODE
<form action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
	
	<fieldset>
		
		<legend>Select Wrapper</legend>
		
		<div class="select-wrapper">
			<select>
				<option>&mdash; Please select &mdash;</option>
				<option>Questions</option>
				<option>Quote</option>
				<option>Something Random</option>
			</select>
		</div>
		
		<legend>Checkbox Wrapper</legend>
		
		<label class="checkbox-wrapper">
			<input type="checkbox" value="">
			<span></span>
			This is a custom checkbox
		</label>
		
		<label class="radio-wrapper">
			<input type="radio" value="">
			<span></span>
			This is a custom radio button
		</label>
		
		<legend>File Wrapper</legend>
		
		<label class="file-wrapper">
			<input type="file" onchange="$(this).parent().find('span').text(this.value.substring(this.value.lastIndexOf('\\')+1));">
			<span>Choose file...</span>
		</label>
		
	</fieldset>
	
</form>
CODE;
output_code($code);
?>

<?php
$code = <<< CODE
<form action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
	
	<fieldset>
		
		<legend>Validation</legend>
		
		<div class="columns grid grid-flush">
			<div class="column-row">
				<div class="column w50">
					<label class="error">Your email<em>*</em></label>
					<input type="text" placeholder="test@mail.com" class="width-full error">
				</div>
				<div class="column w50">
					<label class="success">Reason for contacting</label>
					<select class="width-full success">
						<option>&mdash; Please select &mdash;</option>
						<option>Questions</option>
						<option>Quote</option>
						<option>Something Random</option>
					</select>
				</div>
			</div>
			<div class="column-row">
				<div class="column w100">
					<label class="success">Message</label>
					<textarea placeholder="Your message&hellip;" class="width-full success"></textarea>
				</div>
			</div>
			<div class="column-row">
				<div class="column w100">
					<label class="label-checkbox field_space-top-half pull-right">
						<input type="checkbox"> Checkbox input wrapped in checkbox label
					</label>
					<input type="submit" value="Submit">
				</div>
			</div>
		</div>
		
	</fieldset>
	
</form>
CODE;
output_code($code);
?>

<h3 id="toc_foundation_layout">Layout</h3>

<h4>Columns</h4>

<?php
$code = <<< CODE
<div class="columns demo-columns">
	
	<div class="column w50">
		<p>50%</p>
	</div>
	<div class="column w50">
		<p>50%</p>
	</div>
	
	<div class="column w33">
		<p>33%</p>
	</div>
	<div class="column w33">
		<p>33%</p>
	</div>
	<div class="column w33">
		<p>33%</p>
	</div>
	
	<div class="column w25">
		<p>25%</p>
	</div>
	<div class="column w25">
		<p>25%</p>
	</div>
	<div class="column w25">
		<p>25%</p>
	</div>
	<div class="column w25">
		<p>25%</p>
	</div>
	
	<div class="column w33">
		<p>33%</p>
	</div>
	<div class="column w66">
		<p>66%</p>
	</div>
	
	<div class="column w3-5">
		<p>3/5</p>
	</div>
	<div class="column w2-5">
		<p>2/5</p>
	</div>
	
	<div class="column w100">
		<p>100%, and so on, and so on&hellip;</p>
		
		<div class="columns demo-columns">
			<div class="column w1-2">
				<p>Nested 1/2</p>
				<div class="columns demo-columns">
					<div class="column w1-3">
						<p>Nested 1/3</p>
					</div>
					<div class="column w1-3">
						<p>Nested 1/3</p>
					</div>
					<div class="column w1-3">
						<p>Nested 1/3</p>
					</div>
				</div>
			</div>
			<div class="column w1-2">
				<p>Nested 1/2</p>
				<div class="columns demo-columns">
					<div class="column w1-3">
						<p>Nested 1/3</p>
					</div>
					<div class="column w1-3">
						<p>Nested 1/3</p>
					</div>
					<div class="column w1-3">
						<p>Nested 1/3</p>
					</div>
				</div>
			</div>
		</div>
			
	</div>
	
	
	<div class="column w1-5">
		<p>1/5</p>
	</div>
	<div class="column w1-5 w1-5-prefix w1-5-suffix">
		<p>1/5 with Prefix + Suffix</p>
	</div>
	<div class="column w1-5">
		<p>1/5</p>
	</div>
	
	<div class="column w2-5 w3-5-suffix">
		<p>2/5 with Suffix</p>
	</div>
	
	<div class="column w2-5 w3-5-prefix">
		<p>2/5 with Prefix</p>
	</div>
	
</div>

<hr>

<div class="columns columns-table align-middle demo-columns">
	
	<div class="column w33">
		<p>columns-table<br>align-middle</p>
	</div>
	<div class="column w33">
		<p>example</p>
	</div>
	<div class="column w33">
		<p>Mul<br>ti<br>ple<br>lines</p>
	</div>
	
</div>
CODE;
output_code($code);
?>

<h4>Grid</h4>

<?php
$code = <<< CODE
<div class="columns grid">
	
	<h4>3/4 heading outside of column row will span across column row</h4>
	
	<div class="column-row">
		
		<div class="column w1-4">
			<h6>Heading inside of column wraps inside of column</h6>
			<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id. Ad facer pertinax vel, eum nevelni molestie euripidi consectu. Taleni noluise signiferumque te vix, grae titur temporibus his uta, vis ne nulla nemore splendide. Salutandi scribentur efiantur adta mihis, etoi aliquam vitelre deleniti salutandi ius id. Splendide philosophia est, cum at probo minimu omesque, fali libris has id. Ad facer pertinax vel, eum nevelni molestie euripidi consectu.</p>
		</div>
		
		<div class="column w3-4">
			<p>Splendide philosophia et esti, cum adtam probo minimum omnesque, falli libris has id. Ad facer per inax vel, eum e necie vedeli molestie euripidis conditi ectetuer. Salutandi scrientur efic livian adtam mihis, aliquam vitelre deleniti salutandi ius idoset. Has u eros nobis, melas eu ba error metric possit offendit. Eos velit exerci eami, einic munere intei imicusu eum. Eu unum obique atomorum vix. Doctus omittam pro ex, ut ius autem libris.</p>
			
			<div class="columns">
				
				<h5>Nested 50%</h5>
				
				<div class="column-row">
					
					<div class="column w50">
						<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id.</p>
						
						<div class="columns">
							<h6>Nested 1/2 heading outside of column row will span all columns</h6>
							<div class="column-row">
								<div class="column w1-2">
									<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id.</p>
								</div>
								<div class="column w1-2">
									<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id.</p>
								</div>
							</div>
						</div><!-- /columns -->
						
					</div>
					
					<div class="column w50">
						<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id.</p>
						
						<div class="columns">
							<h6>Nested 1/2 heading outside of column row will span all columns</h6>
							<div class="column-row">
								<div class="column w1-2">
									<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id.</p>
								</div>
								<div class="column w1-2">
									<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id.</p>
								</div>
							</div>
						</div><!-- /columns -->
						
					</div>
					
				</div>
				
			</div><!-- /columns -->
			
		</div>
		
	</div>
	
</div>
CODE;
output_code($code);
?>

<h4>Flexbox Grid</h4>

<?php
$code = <<< CODE
<div class="flex-row demo">
	
	<div class="flex-cell w50">
		<p>50%</p>
	</div>
	<div class="flex-cell w50">
		<p>50%</p>
	</div>
	
	<div class="flex-cell w33">
		<p>33%</p>
	</div>
	<div class="flex-cell w33">
		<p>33%</p>
	</div>
	<div class="flex-cell w33">
		<p>33%</p>
	</div>
	
	<div class="flex-cell w25">
		<p>25%</p>
	</div>
	<div class="flex-cell w25">
		<p>25%</p>
	</div>
	<div class="flex-cell w25">
		<p>25%</p>
	</div>
	<div class="flex-cell w25">
		<p>25%</p>
	</div>
	
	<div class="flex-cell w33">
		<p>33%</p>
	</div>
	<div class="flex-cell w66">
		<p>66%</p>
	</div>
	
	<div class="flex-cell w3-5">
		<p>3/5</p>
	</div>
	<div class="flex-cell w2-5">
		<p>2/5</p>
	</div>
	
	<div class="flex-cell w100">
		<p>100%, and so on, and so on&hellip;</p>
		
		<div class="flex-row">
			<div class="flex-cell w1-2">
				<p>Nested 1/2</p>
				<div class="flex-row">
					<div class="flex-cell w1-3">
						<p>Nested 1/3</p>
					</div>
					<div class="flex-cell w1-3">
						<p>Nested 1/3</p>
					</div>
					<div class="flex-cell w1-3">
						<p>Nested 1/3</p>
					</div>
				</div>
			</div>
			<div class="flex-cell w1-2">
				<p>Nested 1/2</p>
				<div class="flex-row">
					<div class="flex-cell w1-3">
						<p>Nested 1/3</p>
					</div>
					<div class="flex-cell w1-3">
						<p>Nested 1/3</p>
					</div>
					<div class="flex-cell w1-3">
						<p>Nested 1/3</p>
					</div>
				</div>
			</div>
		</div>
			
	</div>
</div>

<hr>

<div class="flex-row flex-row--top">
	
	<div class="flex-cell flex-cell--center w33" style="background: #e3e3e3;">
		<p>columns-table<br>align-middle</p>
	</div>
	<div class="flex-cell flex-cell--bottom w33" style="background: #f3f3f3;">
		<p>example</p>
	</div>
	<div class="flex-cell w33" style="background: #c3c3c3;">
		<p>Mul<br>ti<br>ple<br>lines</p>
	</div>
	
</div>
CODE;
output_code($code);
?>

<?php
$code = <<< CODE
<div class="flex-grid demo">
	
	<h4>3/4 heading outside of column row will span across column row</h4>
	
	<div class="flex-row">
		
		<div class="flex-cell w1-4">
			<h6>Heading inside of column wraps inside of column</h6>
			<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id. Ad facer pertinax vel, eum nevelni molestie euripidi consectu. Taleni noluise signiferumque te vix, grae titur temporibus his uta, vis ne nulla nemore splendide. Salutandi scribentur efiantur adta mihis, etoi aliquam vitelre deleniti salutandi ius id. Splendide philosophia est, cum at probo minimu omesque, fali libris has id. Ad facer pertinax vel, eum nevelni molestie euripidi consectu.</p>
		</div>
		
		<div class="flex-cell w3-4">
			<p>Splendide philosophia et esti, cum adtam probo minimum omnesque, falli libris has id. Ad facer per inax vel, eum e necie vedeli molestie euripidis conditi ectetuer. Salutandi scrientur efic livian adtam mihis, aliquam vitelre deleniti salutandi ius idoset. Has u eros nobis, melas eu ba error metric possit offendit. Eos velit exerci eami, einic munere intei imicusu eum. Eu unum obique atomorum vix. Doctus omittam pro ex, ut ius autem libris.</p>
			
			<div class="columns">
				
				<h5>Nested 50%</h5>
				
				<div class="flex-row">
					
					<div class="flex-cell w50">
						<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id.</p>
						
						<div class="columns">
							<h6>Nested 1/2 heading outside of column row will span all columns</h6>
							<div class="flex-row">
								<div class="flex-cell w1-2">
									<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id.</p>
								</div>
								<div class="flex-cell w1-2">
									<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id.</p>
								</div>
							</div>
						</div><!-- /columns -->
						
					</div>
					
					<div class="flex-cell w50">
						<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id.</p>
						
						<div class="columns">
							<h6>Nested 1/2 heading outside of column row will span all columns</h6>
							<div class="flex-row">
								<div class="flex-cell w1-2">
									<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id.</p>
								</div>
								<div class="flex-cell w1-2">
									<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id.</p>
								</div>
							</div>
						</div><!-- /columns -->
						
					</div>
					
				</div>
				
			</div><!-- /columns -->
			
		</div>
		
	</div>
	
</div>
CODE;
output_code($code);
?>

<h2 id="toc_components">Components</h2>

<h3>Buttons</h3>

<?php
$code = <<< CODE
<a href="" class="button button-xs">Button XS</a>
<a href="" class="button button-s">Button S</a>
<a href="" class="button">Button</a>
<a href="" class="button disabled">Button Disabled</a>
<a href="" class="button button-l">Button L</a>
<a href="" class="button button-xl">Button XL</a>

<hr>

<a class="button" href="#">&lt;a&gt; button</a>
<button>&lt;button&gt; button</button>
<input type="submit" value="&lt;submit&gt; input">
<input type="button" value="&lt;button&gt; input">
CODE;
output_code($code);
?>

<?php
$code = <<< CODE
<a href="" class="button">Button</a>
<a href="" class="button button-link">Button Link</a>
<a href="" class="button button-pill">Button Pill</a>
<br>
<br>
<a href="" class="button button-default">Button Default</a>
<a href="" class="button button-default" disabled="disabled">Button Default Disabled</a>
<a href="" class="button button-message">Button Message</a>
<br>
<br>
<a href="" class="button button-success">Button Success</a>
<a href="" class="button button-error">Button Error</a>
<a href="" class="button button-warning">Button Warning</a>
<a href="" class="button button-info">Button Info</a>
<br>
<br>
<div class="button-group">
	<a href="" class="button">Button Group</a>
	<a href="" class="button">Button Group</a>
	<a href="" class="button">Button Group</a>
</div>
<br>
<div class="button-group">
	<a href="" class="button button-pill">Button Pill Group</a>
	<a href="" class="button button-pill">Button Pill Group</a>
	<a href="" class="button button-pill">Button Pill Group</a>
</div>
CODE;
output_code($code);
?>

<h3>Site Messages</h3>

<h4>CSS Tooltips</h4>

<?php
$code = <<< CODE
<span title="Span tip" class="tip top left">I'm a top left tip</span>
<a href="" title="Span tip" class="tip bottom right">I'm a bottom right tip</a>
CODE;
output_code($code, false);
?>

<h4>Notifications</h4>

<?php
$code = <<< CODE
<div class="notification">
	<p><strong>Message:</strong> Here is a notification <a href="">with a link</a>.</p>
</div>
<div class="notification" data-type="success">
	<p><strong>Success!</strong> Here is a notification <a href="">with a link</a>.</p>
</div>
<div class="notification" data-mode="box" data-type="success">
	<p><strong>Success!</strong> Here is a notification <a href="">with a link</a>.</p>
</div>
<div class="notification" data-type="error">
	<p><strong>Error!</strong> Here is a notification <a href="">with a link</a>.</p>
</div>
<div class="notification" data-mode="box" data-type="error">
	<p><strong>Error!</strong> Here is a notification <a href="">with a link</a>.</p>
</div>
<div class="notification" data-type="warning">
	<p><strong>Warning!</strong> Here is a notification <a href="">with a link</a>.</p>
</div>
<div class="notification" data-mode="box" data-type="warning">
	<p><strong>Warning!</strong> Here is a notification <a href="">with a link</a>.</p>
</div>
<div class="notification" data-type="info">
	<p><strong>Info!</strong> Here is a notification <a href="">with a link</a>.</p>
</div>
<div class="notification" data-mode="box" data-type="info">
	<p><strong>Info!</strong> Here is a notification <a href="">with a link</a>.</p>
</div>
<div class="notification" data-mode="box" data-type="lightbulb">
	<p><strong>Lightbulb!</strong> Here is a notification <a href="">with a link</a>.</p>
</div>
<div class="notification" data-mode="box" data-type="message">
	<h3>Message <span>Heading</span></h3>
	<p>Here is a message <a href="">with a link</a>.</p>
</div>
CODE;
output_code($code);
?>

<h2 id="toc_site-styles">Site Styles</h2>

<h3 id="toc_site-styles_band-wrap-and-liner">Band, Wrap, and Liner</h3>

<?php
$code = <<< CODE
<div class="band-wrap padding-tbs" style="background: rgba(0,0,0,0.6); color: #fff;">
	The band-wrap (optional) can extend to the viewport width and provide background
	
	<div class="band margin-tbs padding-tbs" style="background: rgba(255,255,255,0.6); color: #333;">
		The band (optional) can extend to the viewport width and provide background
		
		<div class="band-liner margin-tbs padding-tbs" style="background: rgba(255,255,255,0.6);">
			The band-liner can extend the target site width responsively and contain content
		</div>
		
	</div>
	
</div>
CODE;
output_code($code, false);
?>

<h3 id="toc_site-styles_content">Content</h3>

<h4>Embed</h4>

<?php
$code = <<< CODE
<div class="columns grid">
	<div class="column-row">
		<div class="column w33">
			<iframe width="100%" src="about:blank" style="background: #ccc;" frameborder="0" allowfullscreen class="embed"></iframe>
		</div>
		<div class="column w33">
			<iframe width="100%" src="about:blank" style="background: #ccc;" frameborder="0" allowfullscreen class="embed embed_4-3"></iframe>
		</div>
		<div class="column w33">
			<div class="embed">
				<iframe width="100%" src="about:blank" style="background: #ccc;" frameborder="0" allowfullscreen></iframe>
				<!--iframe width="640" height="360" src="//www.youtube.com/embed/Z1uvnuQkmUU" frameborder="0" allowfullscreen></iframe-->
			</div>
		</div>
	</div>
</div>
CODE;
output_code($code);
?>

<h4>Images</h4>

<?php
$code = <<< CODE
<img data-src="<?php echo base_url(); ?>javascript/holder.js/200x200/text:Rounded" alt="" title="" class="img img-fluid img-row img-rounded">

<img data-src="<?php echo base_url(); ?>javascript/holder.js/200x200/text:Circle" alt="" title="" class="img img-fluid img-row img-circle ">

<img data-src="<?php echo base_url(); ?>javascript/holder.js/200x200/text:Thumbnail" alt="" title="" class="img img-fluid img-row img-thumbnail">

<a href="" class="img-thumbnail img-dropshadow">
	<img data-src="<?php echo base_url(); ?>javascript/holder.js/200x200/text:<a> Thumbnail Dropshadow" alt="" title="">
</a>
CODE;
output_code($code);
?>

<?php
$code = <<< CODE
<img data-src="<?php echo base_url(); ?>javascript/holder.js/200x200/text:img-left" alt="" title="" class="img-left">

<img data-src="<?php echo base_url(); ?>javascript/holder.js/200x200/text:img-right img-right-clear" alt="" title="" class="img-right img-right-clear">

<img data-src="<?php echo base_url(); ?>javascript/holder.js/200x200/text:img-center" alt="" title="" class="img-center">
CODE;
output_code($code);
?>

<h5>Scale vs Fluid</h5>

<?php
$code = <<< CODE
<p>Space smaller than image</p>

<div class="w10">
	<img src="<?php echo base_url(); ?>images/test/small-0.jpg" alt="" title="" class="img img-scale img-row">
</div>
<div class="w10">
	<img src="<?php echo base_url(); ?>images/test/small-0.jpg" alt="" title="" class="img img-fluid img-row">
</div>

<p>Space larger than image</p>

<img src="<?php echo base_url(); ?>images/test/small-0.jpg" alt="" title="" class="img img-scale img-row">
<img src="<?php echo base_url(); ?>images/test/small-0.jpg" alt="" title="" class="img img-fluid img-row">
CODE;
output_code($code);
?>

<h5>Filters</h5>

<?php
$code = <<< CODE
<img src="<?php echo base_url(); ?>images/test/small-0.jpg" alt="" title="" class="filter-sepia">
<img src="<?php echo base_url(); ?>images/test/small-0.jpg" alt="" title="" class="filter-desaturate2">
<img src="<?php echo base_url(); ?>images/test/small-0.jpg" alt="" title="" class="filter-blur">
CODE;
output_code($code);
?>

<h2 id="toc_responsive">Responsive / Media Queries / Target Devices</h2>

<h3>Breakpoints</h3>

<?php
$code = <<< CODE
<p>Change the browser size to see comparison updates below.</p>
<div class="columns grid">
	<div class="column-row">
		<div class="column column-unresponsive w50">
			<p>Hide</p>
			<ul>
				<li><span class="hide-l">Hide Large</span></li>
				<li><span class="hide-m">Hide Medium</span></li>
				<li><span class="hide-s">Hide Small</span></li>
				<li><span class="hide-xs">Hide XSmall</span></li>
			</ul>
			<p>Hide up</p>
			<ul>
				<li><span class="hide-l-up">Hide Large+</span></li>
				<li><span class="hide-m-up">Hide Medium+</span></li>
				<li><span class="hide-s-up">Hide Small+</span></li>
				<li><span class="hide-xs-up">Hide XSmall+</span></li>
			</ul>
			<p>Hide down</p>
			<ul>
				<li><span class="hide-l-down">Hide Large-</span></li>
				<li><span class="hide-m-down">Hide Medium-</span></li>
				<li><span class="hide-s-down">Hide Small-</span></li>
				<li><span class="hide-xs-down">Hide XSmall-</span></li>
			</ul>
		</div>
		<div class="column column-unresponsive w50">
			<p>Show</p>
			<ul>
				<li><span class="show-l">Show Large</span></li>
				<li><span class="show-m">Show Medium</span></li>
				<li><span class="show-s">Show Small</span></li>
				<li><span class="show-xs">Show XSmall</span></li>
			</ul>
			<p>Show up</p>
			<ul>
				<li><span class="show-l-up">Show Large+</span></li>
				<li><span class="show-m-up">Show Medium+</span></li>
				<li><span class="show-s-up">Show Small+</span></li>
				<li><span class="show-xs-up">Show XSmall+</span></li>
			</ul>
			<p>Show down</p>
			<ul>
				<li><span class="show-l-down">Show Large-</span></li>
				<li><span class="show-m-down">Show Medium-</span></li>
				<li><span class="show-s-down">Show Small-</span></li>
				<li><span class="show-xs-down">Show XSmall-</span></li>
			</ul>
		</div>
	</div>
</div>
CODE;
output_code($code);
?>

	</section>
	<!-- /content -->
	
</div>
<!-- /band-liner -->
</div>
<!-- /band content -->
</div>
<!-- /band-wrap -->


<?php
// Footer
include(THEMEPATH . 'common/footer.php');
?>

</div>
<!-- /body-liner -->

<?php
// Body Append
include(THEMEPATH . 'common/body.append.php');
?>
</body>
</html>