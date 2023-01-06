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

@Component({
  selector: 'app-members-table',
  templateUrl: './members-table.component.html',
  styleUrls: ['./members-table.component.scss'],
})
export class MembersTableComponent implements AfterViewInit, OnInit {
  displayedColumns: string[] = ['name', 'contact', 'address', 'action'];
  dataSource = new MatTableDataSource<PeriodicElement>(ELEMENT_DATA);

  opened = true;
  @ViewChild('sidenav', { static: true }) sidenav: MatSidenav;

  @ViewChild(MatPaginator) paginator: MatPaginator;

  constructor(
    public dialog: MatDialog,
    private ds: DataService,
    private router: Router
  ) {}

  members: any;
  member: any = [];

  ngOnInit(): void {
    this.getMembers();
  }

  getMembers() {
    this.ds._httpRequest('members', null, 1).subscribe((data: any) => {
      this.members = data.payload;
    });
  }

  onSubmit(e: any) {
    let f = e.target.elements;
    let load = {
      member_fname: f.fname.value,
      member_mname: f.mname.value,
      member_lname: f.lname.value,
      member_mobilenum: f.mobilenum.value,
      member_email: f.email.value,
      member_houseno: f.houseno.value,
      member_street: f.street.value,
      member_barangay: f.barangay.value,
      member_city: f.city.value,
    };

    this.ds._httpRequest('members/add', load, 2).subscribe((data: any) => {
      if (data.code == 200) {
      }
    });
    console.log(load);
  }

  editMember(member: any) {
    this.member = member;
    console.log(this.member);
  }

  editMemberRecord(member: any) {
    console.log(member);
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
        Swal.fire({
          title: 'Success',
          text: 'Member has been removed.',
          icon: 'success',
          confirmButtonColor: '#004643',
        });
      }
    });
  }
}

export interface PeriodicElement {
  name: string;
  position: number;
  contact: string;
  address: string;
}

const ELEMENT_DATA: PeriodicElement[] = [
  {
    position: 1,
    name: 'Jerome Socorro Labuguen Marquez',
    contact: '09999999999',
    address: 'Block 35 Lot 7 Sampaguita Street Maligaya Park 1100',
  },
  {
    position: 2,
    name: 'Christian Leroy Jenkins Dantes',
    contact: '09999999999',
    address: '938 Arlegui Corner Aguila Street Quiapo',
  },
  {
    position: 3,
    name: 'Leonardo Eneas Serad Magtibay',
    contact: '09999999999',
    address: 'Neda Sa Pasig Amber Avenue',
  },
  {
    position: 4,
    name: 'Alarico Mitchell Tupas Benítez',
    contact: '09999999999',
    address: ' 7 Capt. Henry Javier Street, Oranbo',
  },
  {
    position: 5,
    name: 'Juan Dela Cruz',
    contact: '09999999999',
    address: 'Blk 2 Lot7 Missoiuri Street Valley View Royale 1500',
  },
  {
    position: 6,
    name: 'Jerome Socorro Labuguen Marquez',
    contact: '09999999999',
    address: 'Block 35 Lot 7 Sampaguita Street Maligaya Park 1100',
  },
  {
    position: 7,
    name: 'Christian Leroy Jenkins Dantes',
    contact: '09999999999',
    address: '938 Arlegui Corner Aguila Street Quiapo',
  },
  {
    position: 8,
    name: 'Leonardo Eneas Serad Magtibay',
    contact: '09999999999',
    address: 'Neda Sa Pasig Amber Avenue',
  },
  {
    position: 9,
    name: 'Alarico Mitchell Tupas Benítez',
    contact: '09999999999',
    address: ' 7 Capt. Henry Javier Street, Oranbo',
  },
  {
    position: 10,
    name: 'Juan Dela Cruz',
    contact: '09999999999',
    address: 'Blk 2 Lot7 Missoiuri Street Valley View Royale 1500',
  },
  {
    position: 11,
    name: 'Jerome Socorro Labuguen Marquez',
    contact: '09999999999',
    address: 'Block 35 Lot 7 Sampaguita Street Maligaya Park 1100',
  },
  {
    position: 12,
    name: 'Christian Leroy Jenkins Dantes',
    contact: '09999999999',
    address: '938 Arlegui Corner Aguila Street Quiapo',
  },
  {
    position: 13,
    name: 'Leonardo Eneas Serad Magtibay',
    contact: '09999999999',
    address: 'Neda Sa Pasig Amber Avenue',
  },
  {
    position: 14,
    name: 'Alarico Mitchell Tupas Benítez',
    contact: '09999999999',
    address: ' 7 Capt. Henry Javier Street, Oranbo',
  },
  {
    position: 15,
    name: 'Juan Dela Cruz',
    contact: '09999999999',
    address: 'Blk 2 Lot7 Missoiuri Street Valley View Royale 1500',
  },
  {
    position: 16,
    name: 'Jerome Socorro Labuguen Marquez',
    contact: '09999999999',
    address: 'Block 35 Lot 7 Sampaguita Street Maligaya Park 1100',
  },
  {
    position: 17,
    name: 'Christian Leroy Jenkins Dantes',
    contact: '09999999999',
    address: '938 Arlegui Corner Aguila Street Quiapo',
  },
  {
    position: 18,
    name: 'Leonardo Eneas Serad Magtibay',
    contact: '09999999999',
    address: 'Neda Sa Pasig Amber Avenue',
  },
  {
    position: 19,
    name: 'Alarico Mitchell Tupas Benítez',
    contact: '09999999999',
    address: ' 7 Capt. Henry Javier Street, Oranbo',
  },
  {
    position: 20,
    name: 'Juan Dela Cruz',
    contact: '09999999999',
    address: 'Blk 2 Lot7 Missoiuri Street Valley View Royale 1500',
  },
];
