import { Component } from '@angular/core';
import { DatePipe } from '@angular/common';
import { NgxSpinnerService } from 'ngx-spinner';
import { ToastrService } from 'ngx-toastr';
import { PlanService } from 'src/app/service/plan.service';
import { UserService } from 'src/app/service/user.service';

@Component({
  selector: 'app-transaction',
  templateUrl: './transaction.component.html',
  styleUrls: ['./transaction.component.css']
})
export class TransactionComponent {
  userObj: any = {
    user_id: localStorage.getItem('userId')
  }
  user_plan: any = [{}];
  plan: any = [{}];
  planObj: any = {
    user_id: localStorage.getItem('userId'),
    plan_id: ''
  }

  isLoader = true;

  constructor(private _planService: PlanService,
    private _spinnerService: NgxSpinnerService,
    private _userService: UserService,
    private _toastr: ToastrService,
  ) { }

  onGetUserPlan() {
    this._userService.onGetPlan(this.userObj).subscribe(res => {
      if (res.success == true) {
        this.user_plan = res.data;
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

  onGetPlan() {
    this.isLoader = true;
    this._planService.onGetPlan().subscribe(res => {
      if (res.success == true) {
        this.isLoader = false;
        this.plan = res.data;
        for (let i = 0; i < this.plan.length; i++) {
          for (let j = 0; j < this.user_plan.length; j++) {
            if (this.plan[i].id == this.user_plan[j].plan_id) {
              this.plan[i].is_add = true;
            }
          }
        }
      }
    }, (err) => {
      this.isLoader = false;
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

  onAddPlan(plan_id: any) {
    this._spinnerService.hide();
    this.planObj.plan_id = plan_id;
    this._planService.onAddPlan(this.planObj).subscribe(res => {
      if (res.success == true) {
        this._spinnerService.hide();
        this._toastr.success(res.msg, 'Success', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
        this.ngOnInit();
      }
    }, (err) => {
      if (err.status == 400) {
        this._spinnerService.hide();
        this._toastr.error(err.error.msg, 'Error', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
    })
  }

  // onAlreadyAdded() {
  //   this._toastr.error('This plan is already added !', 'Error', {
  //     timeOut: 3000,
  //     positionClass: 'toast-top-right',
  //     progressBar: true,
  //     progressAnimation: 'increasing'
  //   }); 
  // } 

  ngOnInit(): void {

    this.onGetUserPlan();
    this.onGetPlan();
  }
}
