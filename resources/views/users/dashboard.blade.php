@extends('layouts.private')

@section('content')
   <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div id="portlet-config" class="modal hide">
				<div class="modal-header">
					<button data-dismiss="modal" class="close" type="button"></button>
					<h3>portlet Settings</h3>
				</div>
				<div class="modal-body">
					<p>Here will be a configuration form</p>
				</div>
			</div>
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN STYLE CUSTOMIZER -->
						
						<div class="color-panel hidden-phone">
							<div class="color-mode-icons icon-color"></div>
							<div class="color-mode-icons icon-color-close"></div>
							<div class="color-mode">
								<p>THEME COLOR</p>
								<ul class="inline">
									<li class="color-black current color-default" data-style="default"></li>
									<li class="color-blue" data-style="blue"></li>
									<li class="color-brown" data-style="brown"></li>
									<li class="color-purple" data-style="purple"></li>
									<li class="color-white color-light" data-style="light"></li>
								</ul>
								<label class="hidden-phone">
								<input type="checkbox" class="header" checked value="" />
								<span class="color-mode-label">Fixed Header</span>
								</label>							
							</div>
						</div>
						<!-- END BEGIN STYLE CUSTOMIZER --> 
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->			
						<h3 class="page-title">
							Dashboard
						</h3>
						@include('common.msg')
						
						@if(isset($notifications) && is_array($notifications) && sizeof($notifications))

						<div class="span6">
							<!-- BEGIN PORTLET-->
							<div class="portlet paddingless">
								<div class="portlet-title line">
									<h4><i class="icon-bell"></i>Reminders</h4>
									{{-- <div class="tools">
										<a href="javascript:;" class="collapse"></a>
										<a href="#portlet-config" data-toggle="modal" class="config"></a>
										<a href="javascript:;" class="reload"></a>
										<a href="javascript:;" class="remove"></a>
									</div> --}}
								</div>
								<div class="portlet-body" id="blinking">
									<!--BEGIN TABS-->
									
									<div class="tabbable tabbable-custom">
										<ul class="nav nav-tabs">
											<li class="active"><a href="#tab_1_1" data-toggle="tab">Followup</a></li>
											<li><a href="#tab_1_2" data-toggle="tab">Bookings</a></li>
										</ul>
										<div class="tab-content">
											<div class="tab-pane active" id="tab_1_1">
												<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
													@if(isset($notifications['followup']) && is_array($notifications['followup']) && sizeof($notifications['followup']))
														<ul class="feeds">
														@foreach($notifications['followup'] as $folloup)
																<li>
																	<div class="col1" style="width:90%;">
																		<div class="cont">
																			<div class="cont-col1">
																				<div class="label label-success">			<i class="icon-bell"></i>
																				</div>
																			</div>
																			<div class="cont-col2">
																				<div class="desc">
																					<a href="{{ route('master.followup.view',['id'=>$folloup->trans_followup_id]) }}">{{ \Str::limit($folloup->description ?? '',25) }}
																					({{ \Str::limit($folloup->title ?? '',10) }})</a>
																					</span>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col2" style="width:20%;">
																		<div class="date">
																			{{ \Helper::converdb2datetime($folloup->created ?? '') }}
																		</div>
																	</div>
																</li>
														@endforeach
														</ul>
													@endif
												</div>
											</div>
											<div class="tab-pane" id="tab_1_2">
												<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
													<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
														@if(isset($notifications['bookings']) && is_array($notifications['bookings']) && sizeof($notifications['bookings']))
															<ul class="feeds">
															@foreach($notifications['bookings'] as $bookings)
																	<li>
																		<div class="col1" style="width:90%;">
																			<div class="cont">
																				<div class="cont-col1">
																					<div class="label label-success">								
																						<i class="icon-bell"></i>
																					</div>
																				</div>
																				<div class="cont-col2">
																					<div class="desc">
																						{{ $bookings->job_number ?? '',25 }}
																						{{-- <span class="label label-important label-mini">
																						Take action 
																						<i class="icon-share-alt"></i> --}}
																						</span>
																					</div>
																				</div>
																			</div>
																		</div>
																		<div class="col2" style="width:20%;">
																			<div class="date">
																				{{ \Helper::converdb2datetime($bookings->created ?? '') }}
																			</div>
																		</div>
																	</li>
															@endforeach
															</ul>
														@endif
													</div>
												</div>
											</div>
										</div>
									</div>
									<!--END TABS-->
								</div>
							</div>
							<!-- END PORTLET-->
						</div>
						@endif
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						
					</div>
				</div>
				<!-- END PAGE CONTENT-->
			</div>
			<!-- END PAGE CONTAINER-->	
			<script>
				$(document).ready(function(){
					setInterval(() => {
						$('#blinking').fadeOut(250).fadeIn(250); 	
					}, 2000);
					
				})
			</script>	
@endsection
