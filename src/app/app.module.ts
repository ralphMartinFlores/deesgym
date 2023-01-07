import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

import { AngularMaterialModule } from './angular-material/angular-material.module';
import { MembersTableComponent } from './components/members-table/members-table.component';
import { EditMemberComponent } from './components/edit-member/edit-member.component';
import { AddMemberComponent } from './components/add-member/add-member.component';
import { TransactionsTableComponent } from './components/transactions-table/transactions-table.component';
import { LoginComponent } from './components/login/login.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { AddTransactionComponent } from './components/add-transaction/add-transaction.component';
import { RouterModule } from '@angular/router';
import { DatePipe } from '@angular/common';

@NgModule({
  declarations: [
    AppComponent,
    MembersTableComponent,
    EditMemberComponent,
    AddMemberComponent,
    TransactionsTableComponent,
    LoginComponent,
    AddTransactionComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    AngularMaterialModule,
    RouterModule,
    FormsModule,
    HttpClientModule,
    AppRoutingModule,
    ReactiveFormsModule,
  ],
  providers: [HttpClient, DatePipe],
  bootstrap: [AppComponent],
})
export class AppModule {}
