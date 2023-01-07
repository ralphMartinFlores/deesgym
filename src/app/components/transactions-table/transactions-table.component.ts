import {
  AfterViewInit,
  Component,
  HostListener,
  OnInit,
  ViewChild,
} from '@angular/core';
import { MatPaginator } from '@angular/material/paginator';
import { MatTableDataSource } from '@angular/material/table';
import { MatSidenav } from '@angular/material/sidenav';
import { MatDialog } from '@angular/material/dialog';
import { AddTransactionComponent } from '../add-transaction/add-transaction.component';
import { DataService } from 'src/app/services/data.service';
import { Subscription } from 'rxjs';
import Swal from 'sweetalert2';
import { DatePipe } from '@angular/common';

@Component({
  selector: 'app-transactions-table',
  templateUrl: './transactions-table.component.html',
  styleUrls: ['./transactions-table.component.scss'],
})
export class TransactionsTableComponent implements AfterViewInit, OnInit{

  trasnsactions: any = [];

  displayedColumns: string[] = ['name', 'type', 'date', 'timein', 'timeout', 'action'];
  dataSource = new MatTableDataSource<TransactionsData>(this.trasnsactions);

  opened = true;
  @ViewChild('sidenav', { static: true }) sidenav: MatSidenav;

  @ViewChild(MatPaginator) paginator: MatPaginator;
  
  message: any;
  private subs: Subscription;

  constructor(public dialog: MatDialog, private ds: DataService, private datepipe: DatePipe) {
    this.subs = this.ds.getUpdate().subscribe(message => {
      this.message = message;
      this.ngOnInit();
    });
  }

  ngOnInit(): void {
    this.getTransactions()
  }

  sendMessage(): void {
    this.ds.sendUpdate('Message from Sender Component to Receiver Component!');
  }

  getTransactions() {
    this.ds._httpRequest('transactions', null, 1).subscribe((data:any)=>{
      this.trasnsactions = data.payload
      this.dataSource = new MatTableDataSource<TransactionsData>(this.trasnsactions);
      console.log(this.trasnsactions)
      console.log(this.dataSource)
      this.dataSource.paginator = this.paginator;  
    });
  }

  timeOut(id: any) {
    let date = new Date()

    let load = {
      trans_timeout: this.datepipe.transform(date, 'hh:mm a')
    }
    
    Swal.fire({
      title: 'All you sure?',
      text: 'You are about to make a new transaction, do you wish to proceed?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#004643',
      cancelButtonColor: '#e16162',
      confirmButtonText: 'Yes, complete transaction',
    }).then((result) => {
      if (result.isConfirmed) {
        this.ds._httpRequest('transactions/update/' + id, load, 2).subscribe((data:any)=>{
          if(data.code == 200) {
            this.sendMessage();
            Swal.fire({
              title: 'Success',
              text: 'Changes have been saved.',
              icon: 'success',
              confirmButtonColor: '#004643',
            });
            this.dialog.closeAll();
          }
        });
      }
    });
  }

  openAddTransactionDialog() {
    let dialogRef = this.dialog.open(AddTransactionComponent, {
      width: '400px',
      height: '90vh',
    });
    dialogRef.afterClosed().subscribe((result) => {
      console.log('Add transaction modal closed.');
    });
  }

  ngAfterViewInit() {
    this.dataSource.paginator = this.paginator;

    console.log(window.innerWidth);
    if (window.innerWidth < 768) {
      this.opened = false;
    } else {
      this.opened = true;
    }
  }

  @HostListener('window:resize', ['$event'])
  onResize(event: { target: { innerWidth: number } }) {
    if (event.target.innerWidth < 768) {
      this.opened = false;
    } else {
      this.opened = true;
    }
  }
  isBiggerScreen() {
    const width =
      window.innerWidth ||
      document.documentElement.clientWidth ||
      document.body.clientWidth;
    if (width < 768) {
      return true;
    } else {
      return false;
    }
  }
}
export interface TransactionsData { }