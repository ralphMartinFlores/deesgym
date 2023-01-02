import {
  AfterViewInit,
  Component,
  HostListener,
  ViewChild,
} from '@angular/core';
import { MatPaginator } from '@angular/material/paginator';
import { MatTableDataSource } from '@angular/material/table';
import { MatDialog } from '@angular/material/dialog';
import { EditMemberComponent } from '../edit-member/edit-member.component';
import { AddMemberComponent } from '../add-member/add-member.component';
import { MatSidenav } from '@angular/material/sidenav';

@Component({
  selector: 'app-members-table',
  templateUrl: './members-table.component.html',
  styleUrls: ['./members-table.component.scss'],
})
export class MembersTableComponent implements AfterViewInit {
  displayedColumns: string[] = ['name', 'contact', 'address', 'action'];
  dataSource = new MatTableDataSource<PeriodicElement>(ELEMENT_DATA);

  opened = true;
  @ViewChild('sidenav', { static: true }) sidenav: MatSidenav;

  @ViewChild(MatPaginator) paginator: MatPaginator;

  constructor(public dialog: MatDialog) {}

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
