				<ul class="nav"><li class="nav-header">Navigation</li>
					@if(Auth::user()->role_id==1 || Auth::user()->role_id==2 || Auth::user()->role_id==3 || Auth::user()->role_id==5)
						@if(Auth::user()->role_id==5)
						<li>
							<a href="{{url('Otorisasi')}}">
								<i class="fas fa-users"></i>
								<span>Personal Otorisasi</span> 
							</a>
						</li>
						@else
						<li>
							<a href="{{url('/')}}">
								<i class="fa fa-th-large"></i>
								<span>Dashboard</span> 
							</a>
						</li>

						@endif
						<li>
							<a href="{{url('Activitas')}}">
								<i class="fas fa-users"></i>
								<span>Personal Activity</span> 
							</a>
						</li>
						
					@endif
					<li>
						<a href="{{url('Project')}}">
							<i class="fas fa-suitcase"></i>
							<span>Project (Project Manager)</span> 
						</a>
					</li>
					<li>
						<a href="{{url('Progresreport')}}">
							<i class="fas fa-calendar-check"></i>
							<span>Progres Report</span> 
						</a>
					</li>
					<li>
						<a href="{{url('Timeseet')}}">
							<i class="fas fa-calendar-check"></i>
							<span>Timesheet</span> 
						</a>
					</li>
					
					
					
					
					<!-- begin sidebar minify button -->
					<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
					<!-- end sidebar minify button -->
				</ul>