import {
  AfterViewInit,
  Component,
  HostListener,
  OnInit,
  ViewChild,
} from '@angular/core';
import { MatPaginator } from '@angular/material/paginator';
import { MatTableDataSource } from '@angular/material/table';
import { MatDialog } from '@angular/material/dialog';
import { EditMemberComponent } from '../edit-member/edit-member.component';
import { AddMemberComponent } from '../add-member/add-member.component';
import { MatSidenav } from '@angular/material/sidenav';
import { DataService } from 'src/app/services/data.service';
import { Router } from '@angular/router';
import Swal from 'sweetalert2';
import { Subscription } from 'rxjs';

@Component({
  selector: 'app-members-table',
  templateUrl: './members-table.component.html',
  styleUrls: ['./members-table.component.scss'],
})
export class MembersTableComponent implements AfterViewInit, OnInit {
  displayedColumns: string[] = ['name', 'contact', 'email', 'address', 'membership_date', 'action'];

  opened = true;
  @ViewChild('sidenav', { static: true }) sidenav: MatSidenav;

  @ViewChild(MatPaginator) paginator: MatPaginator;

  message: any;
  private subs: Subscription;

  constructor(public dialog: MatDialog, private ds: DataService, private router: Router) {
    this.subs = this.ds.getUpdate().subscribe(message => {
      this.message = message;
      this.ngOnInit();
    });
  }

  members: any = [];
  member: any = [];

  dataSource = new MatTableDataSource<MembersData>(this.members);
  ngOnInit(): void {
    this.getMembers();
  }

  sendMessage(): void {
    this.ds.sendUpdate('Message from Sender Component to Receiver Component!');
  }
  
  getMembers() {
    this.ds._httpRequest('members', null, 1).subscribe((data:any)=>{
      this.members = data.payload
      this.dataSource = new MatTableDataSource<MembersData>(this.members);
      console.log(this.members)
      console.log(this.dataSource)
      this.dataSource.paginator = this.paginator;  
    });
  }

  editMember(member: any) {
    this.ds.SharedData = member;
    this.openDialog()
  }

  deleteMember(member_id: any) {
    Swal.fire({
      title: 'Wait a second',
      text: 'Are you sure you want to remove this member?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#004643',
      cancelButtonColor: '#e16162',
      confirmButtonText: 'Yes, remove this member.',
    }).then((result) => {
      if (result.isConfirmed) {
        this.ds._httpRequest('members/remove/' + member_id, null, 2).subscribe((data:any)=>{
          if(data.code == 200) {
            this.sendMessage();
            Swal.fire({
              title: 'Success',
              text: 'Member has been removed.',
              icon: 'success',
              confirmButtonColor: '#004643',
            });
          }
        });
      }
    });
  }

  openDialog() {
    let dialogRef = this.dialog.open(EditMemberComponent, {
      height: '90vh',
    });
    dialogRef.afterClosed().subscribe((result) => {
      console.log('Edit member modal closed.');
    });
  }

  openAddMemberDialog() {
    let dialogRef = this.dialog.open(AddMemberComponent, {
      height: '90vh',
    });
    dialogRef.afterClosed().subscribe((result) => {
      console.log('Add member modal closed.');
    });
  }

  ngAfterViewInit() {
    this.dataSource.paginator = this.paginator;

    console.log(window.innerWidth);
    if (window.innerWidth < 768) {
      // this.sidenav.fixedTopGap = 55;
      this.opened = false;
    } else {
      // this.sidenav.fixedTopGap = 55;
      this.opened = true;
    }
  }

  @HostListener('window:resize', ['$event'])
  onResize(event: { target: { innerWidth: number } }) {
    if (event.target.innerWidth < 768) {
      // this.sidenav.fixedTopGap = 55;
      this.opened = false;
    } else {
      // this.sidenav.fixedTopGap = 55
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

  removeMemberAlert() {
  }
}

export interface MembersData { }