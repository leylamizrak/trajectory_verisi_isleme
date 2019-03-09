
package indirge;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.LinkedList;
import java.util.Random;

public class Agac {

	static int reindeks=-1;
	static Dugum ham_kok=null;
	static Dugum indirgenmis_kok=null;
	static LinkedList<Dugum> liste;
	
	public static void main(String[] args) {

		
		int port = 20224;
		ServerSocket listenSock = null; 
		Socket sock = null;

		try {

			listenSock= new ServerSocket(port);

			while (true) {	   //we want the server to run till the end of times

				sock = listenSock.accept();			 //will block until connection recieved

				BufferedReader br =	new BufferedReader(new InputStreamReader(sock.getInputStream()));
				BufferedWriter bw =	new BufferedWriter(new OutputStreamWriter(sock.getOutputStream()));
				String line = "";
				
				LinkedList<Dugum> koordinat=new LinkedList<Dugum>();
				String[] sayilar = null;
				
				line = br.readLine();

				sayilar=line.split(",");

				System.out.println("dsgdfhjfh");


				 LinkedList<Dugum> liste2=new LinkedList<Dugum>();

				
				/*for(int u=0;u<koordinat.length;u++)
				{
					//System.out.println("Sonuç:"+"i:"+ u+"  !"+koordinat[u]+"!");
				}			
				
				*/
				 
				 int kontrol=Integer.parseInt(sayilar[sayilar.length-2]);
				 int buton=Integer.parseInt(sayilar[sayilar.length-1]);
				 
				 System.out.println("kontrol:"+kontrol+"buton:"+buton);
				
				for(int u=5;u<sayilar.length-3;u+=2)
				{
					koordinat.add(new Dugum(Double.parseDouble(sayilar[u]),Double.parseDouble(sayilar[u+1])));
				
					//System.out.println("Sonuç: "+koordinat[u]+" **** "+koordinat[u+1]);

				}
				Random rnd=new Random();
				for(int u=0;u<koordinat.size();)
				{
					int indeks=rnd.nextInt(koordinat.size());
					System.out.println(indeks);
					liste2.add(new Dugum(koordinat.get(indeks).enlem,koordinat.get(indeks).boylam));
					koordinat.remove(indeks);
					

				}
				
				
				 double minx,miny,maxx,maxy; //minx ve maxx boylam deðerlerini miny ve maxy enlem deðerlerini ifade eder.
				

				
				 maxy=Double.parseDouble(sayilar[0]);
				 miny=Double.parseDouble(sayilar[2]);
				 maxx=Double.parseDouble(sayilar[1]);
				 minx=Double.parseDouble(sayilar[3]);
				 
				 System.out.println(minx);
				 System.out.println(miny);
				 System.out.println(maxy);
				System.out.println(maxx);
				 
				 double degistir;
				 
				 if(maxx<minx)
				 {
					 degistir=maxx;
					 maxx=minx;
					 minx=degistir;
				 }
				
				 if(maxy<miny)
				 {
					 degistir=maxy;
					 maxy=miny;
					 miny=degistir;
				 }
				 
				 System.out.println("*********");
				 
				for(int i=0;i<liste2.size();i++)
				{
					//System.out.println(liste2.get(i).enlem +" "+liste2.get(i).boylam);
				}
				//System.out.println("SÝZE"+liste2.size());
				if(kontrol!=reindeks || (kontrol==reindeks && buton==1 && ham_kok==null) || (kontrol==reindeks && buton==2 && indirgenmis_kok==null) ){
				for(int i=0;i<liste2.size();i++)
				{
					if(buton==1){
					
					if(ham_kok==null)
					{
						ham_kok=new Dugum(liste2.get(0).enlem,liste2.get(0).boylam);
					}
					
					else 
					{ 
						ham_kok=ekle(ham_kok,liste2.get(i).enlem,liste2.get(i).boylam);
						
					}

					}
					else if(buton==2)
					{
						if(indirgenmis_kok==null)
						{
							indirgenmis_kok=new Dugum(liste2.get(0).enlem,liste2.get(0).boylam);
						}
						
						else 
						{
							indirgenmis_kok=ekle(indirgenmis_kok,liste2.get(i).enlem,liste2.get(i).boylam);
							
						}	
					}
				}
				
				}
				
				reindeks=kontrol;
				
				//System.out.println("SORGU");
				
				if(buton==1){
				yazdir(ham_kok);
				liste=new LinkedList<Dugum>();
				sorgula(minx,maxx,miny,maxy,ham_kok);

				}
				else if(buton==2)
				{
					yazdir(indirgenmis_kok);
					liste=new LinkedList<Dugum>();
					sorgula(minx,maxx,miny,maxy,indirgenmis_kok);
					
				}
				
				line="";
				
				System.out.println("    Kalan Noktalar   ");
				for(int i=0;i<liste.size();i++){
					System.out.println((liste.get(i).enlem+","+liste.get(i).boylam));
					line=line+liste.get(i).enlem+","+liste.get(i).boylam+",";
				}
				

				bw.write(line + "\n");
				bw.flush();

				//Closing streams and the current socket (not the listening socket!)
				bw.close();
				br.close();
				sock.close();
			}
			
		} catch (IOException ex) {
			ex.printStackTrace();
		}
	
	}
	
	
	
	public static void sorgula(double minx,double maxx,double miny,double maxy,Dugum nesne)
	{
		
		
		
		if(nesne==null)
			return;
		
		if(minx<nesne.boylam && maxx>nesne.boylam && miny<nesne.enlem && maxy>nesne.enlem)
		{
			System.out.println("Eklendi");
			liste.add(nesne);
			
			sorgula(minx,maxx,miny,maxy,nesne.ilk);
			sorgula(minx,maxx,miny,maxy,nesne.ikinci);
			sorgula(minx,maxx,miny,maxy,nesne.ucuncu);
			sorgula(minx,maxx,miny,maxy,nesne.dorduncu);
			
		}
		
		else if(minx<nesne.boylam && maxx>nesne.boylam)
		{

			if(nesne.enlem<miny)
			{
				sorgula(minx,maxx,miny,maxy,nesne.ilk);
				sorgula(minx,maxx,miny,maxy,nesne.ikinci);	
			}
			
			else if(nesne.enlem>maxy)
			{
				sorgula(minx,maxx,miny,maxy,nesne.ucuncu);
				sorgula(minx,maxx,miny,maxy,nesne.dorduncu);
					
			}
			
		}
		
		else if(miny<nesne.enlem && maxy>nesne.enlem)
		{
			if(nesne.boylam < minx)
			{
				sorgula(minx,maxx,miny,maxy,nesne.ikinci);
				sorgula(minx,maxx,miny,maxy,nesne.dorduncu);
				
			}
			else if(nesne.boylam>maxx)
			{
				sorgula(minx,maxx,miny,maxy,nesne.ilk);
				sorgula(minx,maxx,miny,maxy,nesne.ucuncu);

			}
		}
		
		else if(maxx<nesne.boylam && minx<nesne.boylam && miny>nesne.enlem && maxy>nesne.enlem)
		{			
			sorgula(minx,maxx,miny,maxy,nesne.ilk);

		}
		
		else if(maxx>nesne.boylam && minx>nesne.boylam && miny>nesne.enlem && maxy>nesne.enlem)
		{			
			sorgula(minx,maxx,miny,maxy,nesne.ikinci);

		}
		
		else if(maxx<nesne.boylam && minx<nesne.boylam && miny<nesne.enlem && maxy<nesne.enlem)
		{			

			sorgula(minx,maxx,miny,maxy,nesne.ucuncu);
		}
		
		else if(maxx>nesne.boylam && minx>nesne.boylam && miny<nesne.enlem && maxy<nesne.enlem)
		{			

			sorgula(minx,maxx,miny,maxy,nesne.dorduncu);

		}
	}
	
	
	
	public static Dugum ekle(Dugum d,double enlem,double boylam)
	{
		
		if(d==null)
		{
			d=new Dugum(enlem,boylam);
			return d;
		}
		else
		{
		 	if(enlem>=d.enlem && boylam<=d.boylam)
		 	{
		 		d.ilk=ekle(d.ilk,enlem,boylam);
		 	}
		 	else if(enlem>=d.enlem && boylam>=d.boylam)
		 	{
		 		d.ikinci=ekle(d.ikinci,enlem,boylam);
		 	}
		 	else if(enlem<=d.enlem && boylam<=d.boylam)
		 	{
		 		d.ucuncu=ekle(d.ucuncu,enlem,boylam);
		 	}
		 	else if(enlem<=d.enlem && boylam>=d.boylam){
		 		d.dorduncu=ekle(d.dorduncu,enlem,boylam);
		 	}
		}
		return d;
	}
	
	
	
	public static void yazdir(Dugum d)
	{
		
		if(d!=null)
		{
			System.out.println(d.enlem+"**"+d.boylam);
			System.out.println("Ýlk cocuk");		yazdir(d.ilk);
			System.out.println("Ýkinci cocuk");		yazdir(d.ikinci);
			System.out.println("Ucuncu cocuk");		yazdir(d.ucuncu);
			System.out.println("Dorduncu cocuk");	yazdir(d.dorduncu);
		}
		else 
			System.out.println("null");
		
	}
	
}	