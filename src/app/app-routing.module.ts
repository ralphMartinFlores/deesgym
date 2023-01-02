import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { MembersTableComponent } from './components/members-table/members-table.component';
import { TransactionsTableComponent } from './components/transactions-table/transactions-table.component';

const routes: Routes = [
  { path: '', redirectTo: 'members', pathMatch: 'full' },
  { path: 'members', component: MembersTableComponent },
  { path: 'transactions', component: TransactionsTableComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule],
})
export class AppRoutingModule {}
