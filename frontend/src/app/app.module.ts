
import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './component/login/login.component';
import { HeaderComponent } from './component/layout/header/header.component';
import { FooterComponent } from './component/layout/footer/footer.component';
import { PlanComponent } from './component/plan/plan.component';
import { SidebarComponent } from './component/layout/sidebar/sidebar.component';
import { WorkspaceComponent } from './component/workspace/workspace.component';
import { FormsModule } from '@angular/forms';
import { HTTP_INTERCEPTORS, HttpClientModule } from '@angular/common/http';
import { ToastrModule } from 'ngx-toastr';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { NgxSpinnerModule } from 'ngx-spinner';
import { JwtModule } from '@auth0/angular-jwt';
import { AuthInterceptorService } from './service/authentication/auth-interceptor.service';
import { RegisterComponent } from './component/register/register.component';
import { PdfReadingComponent } from './component/pdf-reading/pdf-reading.component';
import { LoaderComponent } from './component/loader/loader.component';
import { ProfileComponent } from './component/profile/profile.component';
import { ContactComponent } from './component/contact/contact.component';
import { NgbAccordionModule, NgbDropdownModule } from '@ng-bootstrap/ng-bootstrap';
import { DatePipe } from '@angular/common';
import { NgbTooltipModule } from '@ng-bootstrap/ng-bootstrap';
import { TransactionComponent } from './component/transaction/transaction.component';
import { StatisticsComponent } from './component/statistics/statistics.component';
import { ForgetPasswordComponent } from './component/forget-password/forget-password.component';
import { OtpComponent } from './component/otp/otp.component';
import { ResetPasswordComponent } from './component/reset-password/reset-password.component';
import { NgxPaginationModule } from 'ngx-pagination';
import { ThankYouComponent } from './component/thank-you/thank-you.component';
import { PaymentFailedComponent } from './component/payment-failed/payment-failed.component';
import { NgxDocViewerModule } from 'ngx-doc-viewer';


 
export function jwtTokenGetter() {
  return localStorage.getItem('accessToken');
}

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    // DashboardComponent,
    HeaderComponent,
    FooterComponent,
    PlanComponent,
    SidebarComponent,
    WorkspaceComponent,
    RegisterComponent,
    PdfReadingComponent,
    LoaderComponent,
    ProfileComponent,
    ContactComponent,
    TransactionComponent,
    StatisticsComponent,
    ForgetPasswordComponent,
    OtpComponent,
    ResetPasswordComponent,
    ThankYouComponent,
    PaymentFailedComponent,
   
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    HttpClientModule,
    ToastrModule.forRoot(),
    BrowserAnimationsModule,
    NgxSpinnerModule,
    NgbDropdownModule, 
    NgbAccordionModule,
    NgxPaginationModule,
    NgbTooltipModule,
    NgxDocViewerModule,
    JwtModule.forRoot({
      config: {
        tokenGetter: jwtTokenGetter
      }
    })    
  ], 
  providers: [
    { provide: HTTP_INTERCEPTORS, useClass: AuthInterceptorService, multi: true } 
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
