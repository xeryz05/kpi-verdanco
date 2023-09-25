@extends('layouts.admin')
@section('content')
    <div class="main-content app-content">

				<!-- container -->
				<div class="main-container container-fluid">

				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<h4 class="page-title">Edit Physical Availability</h4>
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="javascript:void(0);">Physical Availability</a></li>
							<li class="breadcrumb-item active" aria-current="page">Edit Physical Availability</li>
						</ol>
					</div>
				</div>
				
				<!-- breadcrumb -->

                <!-- row -->
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
									<p class="mg-b-20"></p>
									<div id="wizard1">
										<h3 class="mb-2">Physical Availability Information</h3>
										<section>
											<h2 class="d-none">Physical Availability Information</h2>
											<form action="{{ route('physicalavailability.update', $physicalavailability->id) }}" method="post" enctype="multipart/form-data">
												@csrf
												@method('PUT')

												<div class="control-group form-group">
													<label class="form-label">Period</label>
													<select name="event_id" class="form-select" aria-label="Default select example">
														@foreach ($event as $item)
															<option value="{{ $item->id }}" {{ $item->id == $physicalavailability->event_id ? 'selected' : '' }}>{{ $item->start }} - {{ $item->end }}</option>	
														@endforeach
													</select>
													@error('event_id')
														<div class="alert alert-danger mt-2">
															{{ $message }}
														</div>
													@enderror
												</div>
												<div class="control-group form-group">
													<label class="form-label">Value</label>
													<input type="number" class="form-control required @error('velue') is-invalid @enderror" value="{{ $physicalavailability->value }}" name="value">
													@error('value')
														<div class="alert alert-danger mt-2">
															{{ $message }}
														</div>
													@enderror
												</div>
												<div class="d-flex my-xl-auto right-content align-items-center">
													<div class="pe-1 mb-xl-0">
														<button class="btn btn-primary">Create Data</button>
													</div>
												</div>
											</form>
										</section>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /row -->
				</div>
				<!-- Container closed -->
			</div>
@endsection