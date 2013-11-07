#include <iostream>
#include <cstdlib>
#include <cstdio>
#include <stdio.h>
#include <ctime> //voor rand
using namespace std;

class SLLNode{
	public:
		SLLNode(int element, SLLNode *ptr = NULL){
			info = element; 
			volgende = ptr;	
		}
		int info;
		SLLNode *volgende;
	
	private:

};

class SinglyLinkedList{
	public:
		SinglyLinkedList();
		~SinglyLinkedList();
		void insert(int& i, int& o ) ;
		void remove( int& i ) ;
		void fill_r( int n );
		int get( int& i );
		int length();
		void print();
		void sorteer(); 
		
		int isLeeg() {
			return kop == NULL;
		}
	
	private:
		SLLNode *kop;
		SLLNode *staart;

};

SinglyLinkedList::SinglyLinkedList(){
	kop = NULL;
	staart = NULL;
}	

SinglyLinkedList::~SinglyLinkedList(){
	for(SLLNode *p; !isLeeg(); ){
		p = kop->volgende;
		delete kop;
		kop = p;
	}//for
}

//sorteren van een lijst met behulp van bubblesort 
void SinglyLinkedList::sorteer(){
	int hulp; 
	
	for (SLLNode *temp = kop; temp->volgende != NULL; temp = temp->volgende){
		for (SLLNode *temp2 = temp->volgende; temp2!= NULL; temp2 = temp2->volgende){
			if (temp->info > temp2->info){
				hulp = temp->info;
				temp->info = temp2->info;
				temp2->info = hulp; 
			}//if
		}//for
	}//for 	
}

void SinglyLinkedList::insert(int& i, int& o ){

	if (length() != 0){ //lijst niet leeg
		if (i == 0){//vooraan in de lijst toevoegen 	
			kop = new SLLNode(o,kop);	
		}//if 
		else if(i == length()){//aan staart toevoegen
			staart->volgende = new SLLNode(o);
			staart = staart->volgende;
		}//else
		else if (i > length())
			cout << "Kan niet " << endl;
		else{
			SLLNode *temp = kop; // ergens er tussenin toevoegen
			int tellertje = 0;
				while(tellertje < i-1){ //naar element i-1 lopen 
					temp = temp->volgende;
					tellertje++;
				}//while
			//nu zijn we bij i-1, en maken we een nieuw vakje aan
			//temp wijst naar i-1 
			SLLNode *temp2 = temp; //backup pointer
			temp->volgende = new SLLNode(o,temp2->volgende);
		}//else 
	}//if 
	else if (length() == 0){ //lijst wel leeg 
		kop = new SLLNode(o);
		staart = kop;
	}//else		
}

void SinglyLinkedList::remove( int& i ){
	if (kop != NULL){
		if(kop == staart){ //1 vakje in lijst
			delete kop;
			kop = staart = NULL;
		}//if
		else if (i == 0){ //meer dan 1 vakje en kop wordt verwijderd
			SLLNode *temp = kop;
			kop = kop->volgende;
			delete temp;
		}//else
		else if (i == (length()-1)){ //meer dan 1 vakje en staart wordt verwijderd
			SLLNode *temp = staart;
			SLLNode *temp2 = kop;
			while (temp2->volgende != staart)
				temp2 = temp2->volgende;
			delete temp;
			staart = temp2;
			staart->volgende = NULL;
		}//else
		else if (i >= length())
			cout << "Kan niet " << endl;
			
		else{ //meer dan 1 vakje en een niet-kop wordt verwijderd
			SLLNode *pred, *temp;
			pred= kop;
			temp = kop -> volgende;
			for (int tel =0; tel < i-1; tel++){
				temp = temp->volgende;
				pred = pred->volgende; 
			}//for
			
			if (temp != NULL){
				pred -> volgende = temp -> volgende;
				delete temp; 
			}//if	
		}//else	
	}//if	
}

int SinglyLinkedList::length(){
	int teller = 0;
	SLLNode *temp = kop;
	
	while (temp != NULL){ //niet leeg
		teller++; 
		temp = temp->volgende;
	}//while

	return teller; 
}

int SinglyLinkedList::get(int& i){
	int tel = 0;
	SLLNode *temp = kop;
	if (i > length()){
		cout << "Kan niet" << endl;
		return 1; 
	}//if
	for (tel = 0; tel < i; tel++){
		temp = temp->volgende; //bladeren naar i'de element
	}//for
	return temp->info;
}

void SinglyLinkedList::print(){
  for( int i = 0 ; i < length() ; i++ ){
		int z = get(i);
		cout << "get(i) " << z << endl;
  }//for
  cout << endl; 
}

void SinglyLinkedList::fill_r(int n ){
	srand(time(NULL));  
	if (!length() == 0){
		cout << "Kan niet! Lijst is al een keer gevuld" << endl;
		return;
	}//if		
	for (int i=0; i < n; i++){
		int randomgetal = rand();
  		insert(i,randomgetal);
  }//for
}


int main(){
	int i = 1;
	int a = 1;
	int c = 2; 
	int e = 3;
	int g = 4;
		
	int o = 10; 
	int b = 7;
	int d = 4; 
	int f = 5;
	int h = 2;
	
	SinglyLinkedList();
	SinglyLinkedList sll; 
	sll.fill_r(1);
	sll.insert(i, o);
	sll.insert(a, b);
	sll.insert(c, d);
	sll.insert(e, f);
	sll.insert(g, h);
	sll.print();
	//sll.remove(i);
	
	sll.sorteer();
	sll.print();
}