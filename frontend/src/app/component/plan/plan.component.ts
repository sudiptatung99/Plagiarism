
import { Component, ElementRef, ViewChild } from '@angular/core';
import { NgxSpinnerService } from 'ngx-spinner';
import { ToastrService } from 'ngx-toastr';
import { PlanService } from 'src/app/service/plan.service';
import { UserService } from 'src/app/service/user.service';


@Component({
  selector: 'app-plan',
  templateUrl: './plan.component.html',
  styleUrls: ['./plan.component.css']
})
export class PlanComponent {
  @ViewChild('form') form!: ElementRef;
  // options: Options = {
  //   floor: 1,
  //   ceil: 25
  // };

  encRequest: any;
  accessCode: any;

  input_value = 10;
  initial_price = 200;
  price: any;
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
  ) {
    this.accessCode = 'AVBZ40KL17BA58ZBAB';
  }


  pay() {
    if (this.input_value <= 25) {
      this._planService.countPlan({ user_id: localStorage.getItem('userId') }).subscribe((res) => {
        if (res.success == true) {
          if (res.data <= 200) {
            this._planService.encryptdata({ price: this.price, user_id: this.userObj.user_id, document_no: this.input_value }).subscribe((res) => {
              this.encRequest = res.encrypted_data;
              this.accessCode = res.access_code;
              setTimeout(() => {
                let formSubmit = this.form.nativeElement.submit();
              }, 1000)
            })
          } else {
            this._toastr.error('200 documents has been purchased !', 'Error', {
              timeOut: 3000,
              positionClass: 'toast-top-right',
              progressBar: true,
              progressAnimation: 'increasing'
            });
          }
        }
      }, err => {

      })

    } else {
      this._toastr.error('Document range does not greater than 25 !', 'Error', {
        timeOut: 3000,
        positionClass: 'toast-top-right',
        progressBar: true,
        progressAnimation: 'increasing'
      });
      this.input_value = 25
    }
  }


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

  getRange(event: any) {
    this.input_value = event.target.value;
    this.price = parseInt(`${this.input_value * this.initial_price}`).toFixed(2);
  }

  ngOnInit(): void {
    this.onGetUserPlan();
    this.onGetPlan();
    this.price = parseInt(`${this.input_value * this.initial_price}`).toFixed(2);
  }
  getInput(event: any) {
    if (event.target.value > 25) {
      this._toastr.error('Document range does not greater than 25 !', 'Error', {
        timeOut: 3000,
        positionClass: 'toast-top-right',
        progressBar: true,
        progressAnimation: 'increasing'
      });
      this.input_value = 25
      this.ngOnInit();
      this.price = parseInt(`${this.input_value * this.initial_price}`).toFixed(2);
    } else {
      this.input_value = event.target.value;
      this.price = parseInt(`${this.input_value * this.initial_price}`).toFixed(2);
    }

  }

}
