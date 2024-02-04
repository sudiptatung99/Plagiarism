import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from './component/login/login.component';
import { DashboardComponent } from './component/dashboard/dashboard.component';
import { PlanComponent } from './component/plan/plan.component';
import { WorkspaceComponent } from './component/workspace/workspace.component';
import { AuthGuardService as AuthGuard } from './service/authentication/auth-guard.service';
import { RegisterComponent } from './component/register/register.component';
import { PdfReadingComponent } from './component/pdf-reading/pdf-reading.component';
import { ProfileComponent } from './component/profile/profile.component';
import { ContactComponent } from './component/contact/contact.component';
import { TransactionComponent } from './component/transaction/transaction.component';
import { StatisticsComponent } from './component/statistics/statistics.component';
import { ForgetPasswordComponent } from './component/forget-password/forget-password.component';
import { OtpComponent } from './component/otp/otp.component';
import { ResetPasswordComponent } from './component/reset-password/reset-password.component';
import { ThankYouComponent } from './component/thank-you/thank-you.component';
import { PaymentFailedComponent } from './component/payment-failed/payment-failed.component';
 
const routes: Routes = [
  { path: '', redirectTo: 'login', pathMatch: 'full' },
  { path: 'login', component: LoginComponent ,title: 'eAarjav | Login' },
  { path: 'register', component: RegisterComponent ,title: 'eAarjav | Register' }, 
  { path: 'forget-password', component: ForgetPasswordComponent ,title: 'eAarjav | Forget-Password' }, 
  { path: 'otp', component: OtpComponent,title: 'eAarjav | OTP' }, 
  { path: 'reset-password', component: ResetPasswordComponent ,title: 'eAarjav | Reset-Password' }, 
  { path: 'workspace', component: WorkspaceComponent,title: 'eAarjav | Workspace',canActivate: [AuthGuard] },
  { path: 'statistics', component: StatisticsComponent,title: 'eAarjav | Statistics', canActivate: [AuthGuard] }, 
  { path: 'plan', component: PlanComponent,title: 'eAarjav | Plan', canActivate: [AuthGuard] }, 
  { path: 'transaction', component: TransactionComponent,title: 'eAarjav | Transaction', canActivate: [AuthGuard] }, 
  { path: 'profile', component: ProfileComponent,title: 'eAarjav | Profile', canActivate: [AuthGuard] }, 
  { path: 'contact', component: ContactComponent,title: 'eAarjav | Contact', canActivate: [AuthGuard] }, 
  { path: 'reading/:id', component: PdfReadingComponent,title: 'eAarjav | Workspace', canActivate: [AuthGuard] }, 
  { path: 'payment-success/:id', component: ThankYouComponent,title: 'eAarjav | Thank You', canActivate: [AuthGuard] }, 
  { path: 'payment-failed', component: PaymentFailedComponent,title: 'eAarjav | Thank You', canActivate: [AuthGuard] }, 
];
 
@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
