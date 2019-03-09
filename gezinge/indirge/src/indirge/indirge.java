
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

public class indirge {

	public static void main(String[] args) {
		// TODO Auto-generated method stub
		
	int port = 20222;
		ServerSocket listenSock = null; //the listening server socket
		Socket sock = null;			 //the socket that will actually be used for communication

		

		
		
		try {

			listenSock= new ServerSocket(port);
			

			
			while (true) {	   //we want the server to run till the end of times

				sock = listenSock.accept();			 //will block until connection recieved

		        long lStartTime = System.nanoTime();

				
				BufferedReader br =	new BufferedReader(new InputStreamReader(sock.getInputStream()));
				BufferedWriter bw =	new BufferedWriter(new OutputStreamWriter(sock.getOutputStream()));
				
				String line = "";
				String[] koordinat = null;
				
				line = br.readLine();

				koordinat=line.split(",");

				System.out.println("dsgdfhjfh");


				for(int u=0;u<koordinat.length;u++)
				{
					System.out.println("Sonuç: "+koordinat[u]);
				}
				
				LinkedList<noktalar> liste=new LinkedList<noktalar>();
				
				for(int u=1;u<koordinat.length-1;u+=2)
				{
				
					liste.add(new noktalar(Double.parseDouble(koordinat[u]),Double.parseDouble(koordinat[u+1])));
				
					//System.out.println("Sonuç: "+koordinat[u]+" **** "+koordinat[u+1]);

				}
				
		       
		        
				
				line="";
				LinkedList<noktalar> kalannoktalar;
				kalannoktalar=indirge(liste,0.04);
				System.out.println("    Kalan Noktalar   ");
				for(int i=0;i<kalannoktalar.size();i++){
					System.out.println((kalannoktalar.get(i).lat+","+kalannoktalar.get(i).lng));
					line=line+kalannoktalar.get(i).lat+","+kalannoktalar.get(i).lng+",";
				}
				
				
				 long lEndTime = System.nanoTime();

			        
			        double output = lEndTime - lStartTime;

			        output= output / 1000000000.0;
			        
			        System.out.println("Elapsed time in seconds: " +output);
			        
				System.out.println("LÝSTE:"+liste.size()+"  KALAN:"+kalannoktalar.size());
				
				double oran=(1-(double)kalannoktalar.size()/liste.size())*100;
				
				System.out.println("ORAN:"+oran);
				
				line=line+output+","+oran;
				
				System.out.println("LÝNE"+line);
				
				
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
		
	//****************	
		
		//String str=",-33.800101286571,151.28747820854,-33.890542,151.274856,-33.923036,151.259052,-33.950198,151.259302,-34.028249,151.157507";
		
	}
	
	public static LinkedList<noktalar> indirge(LinkedList<noktalar> liste,double tolerans)
	{
		
		System.out.println("Listenin bas ve son noktasý"+liste.get(0).lat+","+liste.get(0).lng+"-----"+liste.get(liste.size()-1).lat+","+liste.get(liste.size()-1).lng);
		
		if(liste.size()==2)
		{
			System.out.println("Arada nokta kalmamýþtýr");
			return liste;
		}
		else {
			double a=liste.get(liste.size()-1).lng-liste.get(0).lng;
			double b=liste.get(liste.size()-1).lat-liste.get(0).lat;
			double c=-a*liste.get(liste.size()-1).lat+b*liste.get(liste.size()-1).lng;
			double mesafe=-1;
			int indeks = -1;
			for(int i=1;i<liste.size()-1;i++){
				System.out.println("Hesaplanan nokta: "+liste.get(i).lat+"-"+liste.get(i).lng);
	        double uzaklik=a*liste.get(i).lat-b*liste.get(i).lng+c;
			uzaklik=Math.abs(uzaklik)/(Math.sqrt(Math.pow(a, 2)+Math.pow(b, 2)));
			System.out.println(uzaklik);
			if(uzaklik>mesafe)
				{
				mesafe=uzaklik;
				indeks=i;
				}
			
			}
			
			System.out.println("Mesafe: "+mesafe+" eleman: "+(indeks+1));
			
			if(mesafe>tolerans){
				System.out.println("Toleranstan büyük");
				LinkedList<noktalar> ilkkisim = new LinkedList<noktalar>(),ikincikisim = new LinkedList<noktalar>();
				ilkkisim.addAll(liste.subList(0,indeks+1));
				ikincikisim.addAll(liste.subList(indeks,liste.size()));

				ilkkisim=indirge(ilkkisim,tolerans);
				ikincikisim=indirge(ikincikisim,tolerans);
				
				LinkedList<noktalar> birlestir =new LinkedList<noktalar>();
				birlestir.addAll(ilkkisim);
				ikincikisim.remove(0);
				birlestir.addAll(ikincikisim);
				return birlestir;
				
			}
			else {
				System.out.println("Toleranstan küçük");
				LinkedList<noktalar> kalanlar =new LinkedList<noktalar>();
				kalanlar.add(liste.get(0));
				kalanlar.add(liste.get(liste.size()-1));
				return kalanlar;
			}
			
		}
		
	}

}








