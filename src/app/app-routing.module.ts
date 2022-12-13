import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from './components/login/login.component';
import { MembersComponent } from './components/members/members.component';
import { RegisterComponent } from './components/register/register.component';
import { TimeInComponent } from './components/time-in/time-in.component';
import { TransactionsComponent } from './components/transactions/transactions.component';

const routes: Routes = [
  { path: 'register', component: RegisterComponent },
  { path: 'login', component: LoginComponent },
  { path: 'time-in', component: TimeInComponent },
  { path: 'members', component: MembersComponent },
  { path: 'transactions', component: TransactionsComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
