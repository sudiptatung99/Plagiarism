import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { DashboardService } from 'src/app/service/dashboard.service';

@Component({
  selector: 'app-statistics',
  templateUrl: './statistics.component.html',
  styleUrls: ['./statistics.component.css']
})
export class StatisticsComponent {
  url = '';
  userObj: any = {
    user_id: localStorage.getItem('userId')
  };
  dashboardDetails: any;
  total: any;
  isLoader = false;

  constructor(private _router: Router,
    private _dashboard: DashboardService) {
    this.url = _router.url;
    this.url = this.url.replace('/', '');
  }

  getDashboard() {
    this.isLoader = true;
    this._dashboard.onGetDashboardData(this.userObj).subscribe(res => {
      if (res.success == true) {
        this.isLoader = false;
        this.dashboardDetails = res;
        this.total = Number(this.dashboardDetails.usesDoc) + Number(this.dashboardDetails.remainDoc);
      }

    },(error)=>{
      this.isLoader = false;
    })
  }


  ngOnInit(): void {
    this.getDashboard();
  }
}
