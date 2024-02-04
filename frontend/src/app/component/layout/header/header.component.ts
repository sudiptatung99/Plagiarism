import { ViewEncapsulation } from '@angular/compiler';
import { Component, inject } from '@angular/core';
import { Router } from '@angular/router';
import { ToastrService } from 'ngx-toastr';
import { Subscription } from 'rxjs';
import { DashboardService } from 'src/app/service/dashboard.service';
import { PlanService } from 'src/app/service/plan.service';
import { UserService } from 'src/app/service/user.service';
declare var $: any;

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css'],
})
export class HeaderComponent {

  closePopup = true;
  userObj: any = {
    user_id: localStorage.getItem('userId')
  };
  clickEventSubscription: Subscription;
  details: any = {};
  loader = true;
  dashboardDetails: any;
  planBlock = false
  constructor(private _userService: UserService,
    private _planService: PlanService,
    private _toastr: ToastrService,
    private _dashboard: DashboardService,
    private _route: Router) {
    this.clickEventSubscription = this._dashboard.getClickEvent().subscribe(() => {
      this.onGetDetails();
      this.getDashboard();
    })
  }
  getDocumentCount() {
    this._planService.countPlan({ user_id: localStorage.getItem('userId') }).subscribe((res) => {
      if (res.success == true) {
        if (res.data <= 200) {
        } else {
          this.planBlock = true;
        }
      }
    }, err => {

    })

  }

  onGetDetails() {
    this._userService.onGetDetails(this.userObj).subscribe(res => {
      this.loader = false;
      if (res.success == true) {
        this.details = res.data;
      }
    }, (err) => {
      if (err.status == 400) {
        this._toastr.error(err.error.msg, 'Error', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
    })
  }
  getDashboard() {
    this.loader = true;
    this._dashboard.onGetDashboardData(this.userObj).subscribe(res => {
      if (res.success == true) {
        this.dashboardDetails = res;
        this.loader = false;
      }
    }, (error) => {
      this.loader = false;
    })
  }

  close() {
    this.closePopup = false;
  }

  onLogout() {
    localStorage.clear()
    window.location.href = '/';
  }

  showError() {
    this._toastr.error('200 documents has been purchased !', 'Error', {
      timeOut: 3000,
      positionClass: 'toast-top-right',
      progressBar: true,
      progressAnimation: 'increasing'
    });
  }



  check_document() {
    this._route.navigate(['/workspace']);
    setTimeout(() => {
      $("#staticBackdrop").modal("show");
    }, 100)

  }

  ngOnInit(): void {
    this.onGetDetails();
    this.getDashboard();
    this.getDocumentCount()
  }

}
