<?php
	if($out_of_index == 1)
		die("Page Not Found");
	else if($out_of_index == 2)
		die("Permission Denied");

	if($qstn_not_avail == 1)
		die("questionnaire does not exist for particular scheme and stage. Please contact the manage team and ask them to create a questionnaire");

	$tracksheet_id = $this->uri->segment(3);
	$level = $this->uri->segment(4);
?>

<!--------client details-------->
    <section class="content">
        <!-- left column -->
        <div class="col-md-12">
              <!-- general form elements -->                
            <div class="box box-primary">
                <div class="box-header with-border">
	              	<h3 class="box-title">Client Details</h3>

	              	<div class="box-tools pull-right">
	                	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	              	</div>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body">
		            <div class="col-md-6 col-sl-12 col-xs-12">
		                <ul class="nav nav-stacked">
		                	<?php 
		                		$tracksheet_id=$database_record->tracksheet_id;

		                		$cm_id=$database_record->cm_id;

								$cb_type=$database_record->cb_type;
								$cb_type_name = 0;
								if($cb_type == 1)
									$cb_type_name = "EAS";
								else
									$cb_type_name = "IAS";
							?>	
		                	<li><a href="#">Customer ID<span class="pull-right  "><?php echo $cb_type_name .sprintf("%05d", $database_record->client_id); ?></span></a></li>
		                	<li><a href="#">Organisation Name<span class="pull-right  "><?php echo $database_record->client_name; ?></span></a></li>
		                	<li><a href="#">Address<span class="pull-right  "><?php echo $database_record->contact_address; ?></span></a></li>
		                	
		                	<?php		                		
		                		foreach ($get_site_records as $key => $get_site_record)
		                		{
		                			$site_address = $get_site_record['site_address'];
		                	?>
		                			<li><a href="#">Site <?php echo $key + 1; ?> Address<span class="pull-right  "><?php echo $site_address; ?></span></a></li>
		                	<?php
		                		}
		                	?>
		                </ul>
		            </div>
		            <div class="col-md-6 col-sl-12 col-xs-12">
		                <ul class="nav nav-stacked">
		                  	<li><a href="#">Scope<span class="pull-right  ">
		                  		<?php 
		                  			if($level == 3 || $level == 4)
						            {						                
		                  				echo $database_record->scope; 
						            }
						            else
						            {
						               echo $app_rev_form_record->scope; 
						            }
		                  		?>	
		                  		</span></a>
		                  	</li>
		                  	<li>
		                  		<a href="#">ANZSIC Codes<span class="pull-right">
		                  		<?php 
		                  			$anzsic_code = "";
		                  			foreach ($app_rev_anzsic_code_record as $key => $value) 
		                  			{
		                  				$anzsic_code = $anzsic_code . ", " . $value['anzsic_code'];
		                  			}

		                  			$anzsic_code = ltrim($anzsic_code, ',');
		                  			echo $anzsic_code;
		                  		?>		                  		
		                  		</span></a>
		                  	</li>
		                  	<li><a href="#">Auditor Name<span class="pull-right  "><?php echo $get_auditor_name['username']; ?></span></a></li>
		              </ul>
		            </div>		            
	            </div>           
            </div>
        </div>
	</section>

<!------form questionnaire qstns----->
<?php
//function to get options
	function to_get_options($answer_options)
	{
		if($answer_options == 1)
		{
			echo "<option value=\"1\">C</option>";
			echo "<option value=\"2\">Minor NC</option>";
			echo "<option value=\"3\">Major NC</option>";
			echo "<option value=\"4\">Observation</option>";
		}
		else if($answer_options == 2)
		{
			echo "<option value=\"2\">Minor NC</option>";
			echo "<option value=\"1\">C</option>";
			echo "<option value=\"3\">Major NC</option>";
			echo "<option value=\"4\">Observation</option>";
		}	
		else if($answer_options == 3)
		{
			echo "<option value=\"3\">Major NC</option>";
			echo "<option value=\"1\">C</option>";
			echo "<option value=\"2\">Minor NC</option>";				
			echo "<option value=\"4\">Observation</option>";
		}	
		else if($answer_options == 4)
		{
			echo "<option value=\"4\">Observation</option>";
			echo "<option value=\"1\">C</option>";
			echo "<option value=\"2\">Minor NC</option>";
			echo "<option value=\"3\">Major NC</option>";				
		}
		else
		{
			echo "<option value=\"0\">NA</option>";
		}												
	}

//displaying already existing questions
	foreach ($get_all_infos_of_nc as $key => $get_all_infos_of_nc)
	{
		$nc_id = $get_all_infos_of_nc['id'];

		$nc_qstn_id = $get_all_infos_of_nc['qstn_id'];
		$qstn_title = $get_all_infos_of_nc['qstn_title'];

		$nc_statement = $get_all_infos_of_nc['nc_statement'];
		$correction = $get_all_infos_of_nc['correction'];
		$root_cause = $get_all_infos_of_nc['root_cause'];
		$corrective_action = $get_all_infos_of_nc['corrective_action'];

		$nc_clear_status = $get_all_infos_of_nc['nc_clear_status'];

	?>
		<section class="content">
			<div class="col-md-12 col-xs-12 col-sl-12">			            
	            <div class="box box-primary">
	            	<!-- /.box-header -->
	                <div class="box-header with-border">
		              	<h3 class="box-title"></h3>
		              	<div class="box-tools pull-right">
		                	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		              	</div>
		            </div>
		            
		            <div class="box-body checklist_qstn_ans" nc_id="<?php echo $nc_id; ?>" qstn_id="<?php echo $nc_qstn_id; ?>">
		            <!------question and answer area---------->	
	            		<div class="col-md-12 col-xs-12 col-sl-12 checklist_qstn">
	            			<?php echo $qstn_title; ?>
	            		</div>	
	            		<div class="col-md-2 col-xs-2 col-sl-2" style="padding: 0; margin: 0; padding-right: 3px;">
	            			<?php
	            				$page_id = $get_questionnaire_form_anss[0]['page_id'];

	            			//for getting options type answer for that qstn
	            				foreach ($get_questionnaire_form_anss as $key => $get_questionnaire_form_ans)
	            				{
	            					$qstn_id = $get_questionnaire_form_ans['qstn_id'];
	            					$ans_type = $get_questionnaire_form_ans['ans_type'];

	            					if($qstn_id == $nc_qstn_id && $ans_type == 1)
	            					{
	            						$answer = $get_questionnaire_form_ans['answer'];
	            						$answer_options = $answer;
	            						break;
	            					}
	            				}

	            			//for getting remarks type answer for that qstn
	            				foreach ($get_questionnaire_form_anss as $key => $get_questionnaire_form_ans)
	            				{
	            					$qstn_id = $get_questionnaire_form_ans['qstn_id'];
	            					$ans_type = $get_questionnaire_form_ans['ans_type'];

	            					if($qstn_id == $nc_qstn_id && $ans_type == 2)
	            					{
	            						$answer = $get_questionnaire_form_ans['answer'];
	            						$answer_remarks = $answer;
	            						break;
	            					}
	            				}
	            			?>
							<select class="checklist_option" disabled="disabled">
								<?php
									to_get_options($answer_options);
								?>
							</select>
						</div>
						<div class="col-md-10 col-xs-10 col-sl-10" style="padding: 0; margin: 0;">
							<?php								
								echo "<div class=\"checklist_ans_view\">$answer_remarks</div>";
							?>		
						</div>

					<!----------watch history area--------->
						<div class="watch_history_area">
						</div>

						<button class="btn btn-primary watch_history_btn">Watch Edit History</button>
						<br><br>

					<!------nc statement area---------->	
						<div class="col-md-12 col-sl-12 col-xs-12" style="padding: 0; margin: 0;">
							<b>Non Conformity Statement</b>
							<textarea class="nc_statement" disabled="disabled"><?php echo $nc_statement; ?></textarea>					
						</div>

					<!-------client reply area--->
						<div class="col-md-12 col-sl-12 col-xs-12" style="padding: 0; margin: 0;">						
							<b>Root Cause Analyse</b>
							<div class="root_cause_ana_div"><?php echo $root_cause; ?></div>

							<b>Correction</b>
							<div class="correction_div"><?php echo $correction; ?></div>

							<b>Corrective Action</b>
							<br>
							<?php
								$corrective_action_array = explode('.', $corrective_action);
								$file_name = $corrective_action_array[0];

								$comparable_file_name = md5("corr_acc_" . $tracksheet_id . "_" . $level . "_" . $nc_id);

								if($file_name == $comparable_file_name)
								{
									$url = base_url('uploads/audit_report_nc_docs/' . $corrective_action);
									echo "<a class=\"btn btn-primary\" target=\"_blank\" href=\"$url\">View Attached Document</a>";
								}
								else
								{
									echo "<div class=\"corrective_action_div\">$corrective_action</div>";
								}
							?>
						</div>
	            	
					<!------- auditor and reviewer comment area--------->
						<div class="col-md-12 col-xs-12 col-sl-12" style=" padding: 0; margin: 0;">
							<br>
							<h4>Comment Section</h4>
							<?php
								foreach ($get_audit_report_comments as $key => $get_audit_report_comment)
								{
									$comment_qstn_id = $get_audit_report_comment['qstn_id'];

									if($comment_qstn_id == $nc_qstn_id)
									{
										$comment = $get_audit_report_comment['comment'];
										$comment_type = $get_audit_report_comment['comment_type'];
										$commented_by = $get_audit_report_comment['username'];

										$comment_type_text = "";
										if($comment_type == 1)
											$comment_type_text = "Reviewer";
										else if($comment_type == 2)
											$comment_type_text = "Auditor";
								?>
										<div class="prev_comment_div">
											<b><?php echo $comment_type_text . ": " . $commented_by; ?></b>
											<br>
											<?php echo $comment; ?>
										</div>
								<?php		
									}
								}
							?>

							<textarea class="checklist_comment_textarea"></textarea>
							<br>
							<button class="btn btn-primary pull-right add_cmmnt_btn">Add Comment</button>
							<br><br>												
						</div>		

					<!-----approve NC area---------->
						<?php					
							echo "<div class=\"col-sl-12 col-md-12 col-xs-12 text-center\">";	
								if($nc_clear_status == 2)
								{	
									echo "<b style=\"color: green\">This NC has been cleared</b>";							
								}
								else
								{
									echo "<button class=\"btn btn-success clear_nc_btn\">Clear NC</button>";
								}
							echo "</div>";
						?>
	            	</div>
	            </div>
	        </div>
	    </section>
	<?php
		}
?>

<!--------summary of the audit report--------->
	<?php
		if($level != 1)
		{
	?>
	   <section class="content">
	        <!-- left column -->
	        <div class="col-md-12">
	            <!-- general form elements -->                
	            <div class="box box-primary">
	                <div class="box-header with-border">
		              	<h3 class="box-title">Summary of the Audit Report</h3>

		              	<div class="box-tools pull-right">
		                	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		              	</div>
		            </div>

		            <!-- /.box-header -->
		            <div class="box-body">
			            <div class="col-md-12 col-sl-12 col-xs-12">
		            	<?php
		            	//function to get audit stage options
		            		function to_get_stage_of_audit($stage)
		            		{
		            			if($stage == 1)
		            			{
		            				echo "<option value=\"1\">Initial Certification</option>";
		            			}
		            			else if($stage == 2)
		            			{
									echo "<option value=\"2\">Post Audit</option>";
		            			}
		            			else if($stage == 3)
		            			{
		            				echo "<option value=\"3\">Surveillance</option>";
		            			}
		            			else if($stage == 4)
		            			{
		            				echo "<option value=\"4\">Modification</option>";
		            			}
		            			else if($stage == 5)
		            			{
		            				echo "<option value=\"5\">Renewal</option>";
		            			}
		            			else if($stage == 6)
		            			{
		            				echo "<option value=\"6\">Upgrade From</option>";
		            			}
		            			else if($stage == 7)
		            			{
		            				echo "<option value=\"7\">Other</option>";	            				
		            			}
		            			else
		            			{
		            				echo "<option value=\"0\">NA</option>";
		            			}
		            		}

		            	//function to get recommendation options
		            		function to_get_recomm($recomm)
		            		{
		            			if($recomm == 1)
		            			{
		            				echo "<option value=\"1\">Issuance of Certificate</option>";
		            			}
		            			else if($recomm == 2)
		            			{
		            				echo "<option value=\"2\">Use of the EAS & JAS-ANZ Logo</option>";
		            			}
		            			else if($recomm == 3)
		            			{
		            				echo "<option value=\"3\">Refusal of the Certificate</option>";
		            			}
		            			else if($recomm == 4)
		            			{
		            				echo "<option value=\"4\">Post audit</option>";
		            			}
		            			else if($recomm == 5)
		            			{
		            				echo "<option value=\"5\">Modification of the current certificate (registration n° and expiration date remain unchanged)</option>";		            				
		            			}
		            			else if($recomm == 6)
		            			{
		            				echo "<option value=\"6\">Other</option>";        				
		            			}		            		
		            			else
		            			{
		            				echo "<option value=\"0\">NA</option>";
		            			}
		            		}

		            	//function to get reason options
		            		function to_get_reason($reason)
		            		{
		            			if($reason == 1)
		            			{
		            				echo "<option value=\"1\">1</option>";
		            			}
		            			else if($reason == 2)
		            			{
		            				echo "<option value=\"2\">2</option>";
		            			}
		            			else if($reason == 3)
		            			{
		            				echo "<option value=\"3\">3</option>";
		            			}
		            			else if($reason == 4)
		            			{		            				
		            				echo "<option value=\"4\">4</option>";
		            			}		            				            	
		            			else
		            			{
		            				echo "<option value=\"0\">NA</option>";
		            			}
		            		}

		            	//getting audit summary records
		            		$surv_date = 0;
		            		$date = 0;
		            		$minor = 0;
		            		$major = 0;
		            		
		            		foreach ($get_audit_summary_records as $key => $get_audit_summary_record)
		            		{
		            			$row_id = $get_audit_summary_record['id'];

		            			$minor = $get_audit_summary_record['minor'];
		            			$major = $get_audit_summary_record['major'];

		            			$stage = $get_audit_summary_record['stage'];
		            			$recomm = $get_audit_summary_record['recomm'];
		            			$reason = $get_audit_summary_record['reason'];

		            			$surv_date = $get_audit_summary_record['surv_date'];
		            			$date = $get_audit_summary_record['date'];	

		            			$approved_by_reviewer = $get_audit_summary_record['approved_by_reviewer'];	            			
		            		}
		            	?>

			            <!--count of major and minor NCs------->	
			            	<b><?php echo $minor; ?> Minor/ <?php echo $major; ?> Major Non Conformance identified in the Stage 2 audit,  details of Non Conformance</b> Please respond by using your own corrective action form and include the root cause analysis with systemic corrective action. Failure to include root cause analysis with systemic corrective action will result in your responses being rejected by Lead Auditor
			            	<br><br>

			            	<b>A.	Stage of audit:</b>
			            	<select id="stage_of_audit" style="height: 34px;" disabled="disabled">
			            		<?php to_get_stage_of_audit($stage); ?>
			            	</select>
			            	<br><br>

			            	<b>B.	Recommendation</b>
			            	<select id="recomm" style="height: 34px;" disabled="disabled">
			            		<?php to_get_recomm($recomm); ?>
			            	</select>
			            	<br><br>

			            	<b>C.	Reason</b>
			            	<select id="reason" style="height: 34px;" disabled="disabled">
			            		<?php to_get_reason($reason); ?>	            		
			            	</select>
			            	<ul class="nav nav-stacked">
			            		<li><b>1. The Information Security Management Systems complies with the requirements of the reference standard:</b> Congratulations, on the basis of the above summary, Lead Auditor is pleased to put forward a recommendation for issuance of certificate.</li>

			            		<li><b>2. The Information Security Management Systems complies with the requirements of the reference standard with exception of minor NC:</b> Congratulations, Lead Auditor is pleased to put forward a recommendation for registration of Organization upon off-site verification of closure of all issues within 90 days from the date of Stage 2 audit.  If all non-conformances are not closed within 90 days, a full reassessment may be required.</li>

			            		<li><b>3. Evidence of major non conformities: </b> Organization is not recommended for next assessment at this time. A follow-up assessment will be scheduled to allow for on-site verification and closure of all issues within 60 days from the date of Stage 2 audit. If all non-conformances are not closed within 60 days, a full reassessment may be required.</li>

			            		<li><b>4. Not Recommended: </b> Organization is not recommended for certification, a Stage 2 audit will be required. To progress your application for registration, please respond to each non-conformances, with a plan showing proposed actions, timescales and responsibilities for resolution. The organization should consider the root cause of the non-conformance and the potential for related issues in other parts of your system.</li>
			            	</ul>
			            	<br>

			            	<i>Disclaimer: Auditing is based on a sampling process of the available information. The results were arrived based on the sample verified.</i>
			            	<br><br>

			            	<b>Proposed Audit Date for Surveillance Audit: </b> 
			            	<input id="surv_date" type="date" disabled="disabled" style="height: 34px; width: auto;" value="<?php echo $surv_date; ?>">
			            	<br><br>

			            	<b>Sign Off Date: </b>
			            	<input id="date" type="date" disabled="disabled" style="height: 34px; width: auto;" value="<?php echo $date; ?>">
		            	</div>
		            </div>
		        </div>
		    </div>
		</section>
	<?php		
		}
	?>

<!-----successful completion of re-audit area-------->
	<div class="col-md-12 text-center">
		<button class="btn btn-danger disapprove_btn">Disapprove</button>
		<button class="btn btn-success approve_btn">Forward to Next Stage</button>
		<br>
	</div>

<!-------style and script--------->
	<style type="text/css">
		.checklist_title_data
		{
			padding: 3px;
			font-size: 120%;
		}

		.checklist_qstn
		{	
			background: #e1e1e1;
			border: 1px silver solid;
			vertical-align: top;
			padding: 3px;
			margin-bottom: 2px;
		}

		.checklist_ans
		{
			min-height: 80px;
			width: 100%;
			padding: 3px;
			margin: 0px;
			resize: none;
			vertical-align: top;
		}

		.checklist_ans_view
		{
			background: #f5f5f5;
			border: 1px lightgrey solid;
			width: 100%;
			padding: 1px;
			margin-bottom: 10px;
			vertical-align: top;
			min-height: 50px;
		}

		.checklist_option
		{
			width: 100%;			
			height: 34px;
			padding: 3px;
			margin: 0px;
		}

		.nc_statement
		{
			min-height: 60px;
			width: 100%;
			padding: 3px;
			margin: 0px;
			resize: none;
			vertical-align: top;
		}

		.correction_div, .root_cause_ana_div, .corrective_action_div
		{
			background: #e1e1e1;
			border: 1px silver solid;
			vertical-align: top;
			padding: 3px;
			margin-bottom: 2px;
			min-height: 20px;
		}

		.checklist_comment_textarea
		{
			background: #f5f5f5;
			border: 1px lightgrey solid;
			min-height: 20px;
			width: 100%;
			padding: 1px;
			margin-bottom: 10px;
			vertical-align: top;
			resize: none;
		}
	</style>

	<script type="text/javascript">
	//variables
		var tracksheet_id = "<?php echo $tracksheet_id ?>";
		var level = "<?php echo $level ?>";
	
	//on clicking on add comment button
		$('.add_cmmnt_btn').click(function()
		{
			$(this).hide();
			
			var this_paa = $(this).parent();

			var comment = this_paa.find('.checklist_comment_textarea').val();
			var qstn_id = this_paa.parent().attr('qstn_id');
			var comment_type = 1;

			$.post("<?php echo base_url('auditor_actions/add_audit_report_comments_in_db'); ?>", {tracksheet_id: tracksheet_id, level: level, qstn_id: qstn_id, comment: comment, comment_type: comment_type}, function(data)
			{
				if(data == 1)
					location.reload();
				else	
					alert('something went wrong while inserting comment into the database.');
			});
		});

	//on clicking on watch history button
		$('.watch_history_btn').click(function()
		{
			$(this).hide();

			var this_paa = $(this).parent();
			var qstn_id = this_paa.attr('qstn_id');
			
			$.post("<?php echo base_url('auditor/watch_history_of_answers'); ?>", {qstn_id: qstn_id, tracksheet_id:tracksheet_id}, function(data)
			{
				this_paa.find('.watch_history_area').html(data);
			});						
		});	

	//on clicking on clear nc button
		$('.clear_nc_btn').click(function()
		{
			$(this).hide();

			var nc_id = $(this).parent().parent().attr('nc_id');
			//alert(nc_id);

			$.post("<?php echo base_url('auditor_actions/clear_audit_report_nc'); ?>", {nc_id: nc_id}, function(data)
			{
				if(data == 1)
					location.reload();
				else	
					alert('something went wrong while clearing this NC');
			});
		});	
	
	//on clicking on disapprove report button
		$('.disapprove_btn').click(function()
		{
			location.href = "<?php echo base_url('auditor/list_to_review_audit_reports') ?>";
		});

	//on clicking on Forward to Next Stage button
		$('.approve_btn').click(function()
		{
			$(this).hide();

			$.post("<?php echo base_url('technical_action/incr_flow_status_of_tracksheet'); ?>", {tracksheet_id: tracksheet_id}, function(data)
			{
				if(data == 1)
					location.href = "<?php echo base_url('auditor/list_to_review_audit_reports') ?>";
				else
					alert('something went wrong.');
			});
		});
	</script>