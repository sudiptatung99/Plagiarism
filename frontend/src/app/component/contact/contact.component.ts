import { Component } from '@angular/core';
import { NgbAccordionModule } from '@ng-bootstrap/ng-bootstrap';
import { NgxSpinnerService } from 'ngx-spinner';
import { ToastrService } from 'ngx-toastr';
import { ProfileService } from 'src/app/service/profile.service';
import { UserService } from 'src/app/service/user.service';
declare var $: any;
@Component({
  selector: 'app-contact',
  templateUrl: './contact.component.html',
  styleUrls: ['./contact.component.css']
})
export class ContactComponent {
  userObj: any = {
    user_id: localStorage.getItem('userId')
  }
 
  profileObj:any;
  lastname:any;
  last_name:any;
  loading=true;
  faq: any = [{}];
  url:any;
  // nameData:any;
  isLoader=false;
  constructor(private _profile: ProfileService,
    private _toastr: ToastrService,
    private _user: UserService,
    private _spinnerService: NgxSpinnerService) { 
      // this.url = "";
      
    }
  getProfile() {
    this._profile.onGetProfile(this.userObj).subscribe(res => {
      if (res.success == true) {
        this.profileObj = res.data.firstname
        this.lastname = res.data.lastname;
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
    }
    )
  }

  getFaq(){
    this.loading=true;
    this._user.getFaq().subscribe((res:any)=>{
      if (res.success == true) {
        this.loading=false;
        this.faq = res.data;
      }
    },err=>{
      this.loading=false;
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
  ngOnInit(): void {
    this.getProfile();
    this.getFaq();
  }
}
