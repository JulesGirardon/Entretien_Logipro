//Pour éviter les problèmes, ce fichier doit être enregistré au format UTF-8
//Grâce à ce commentaire qui contient des caractères accentués, c'est le cas.

class CDoubleApprox {
private:
	double m_dVal = 0;
public:
	// Constucteur de la classe 
	CDoubleApprox() {};
	CDoubleApprox(double dVal) { m_dVal = dVal; };

	// Getter et setter
	double to_double() const { return m_dVal; };
	void set_double(double db) { m_dVal = db; }

	// Operateurs d'égalités
	bool operator==(CDoubleApprox db);
	bool operator!=(CDoubleApprox db);

	// Operateurs de comparaisons
	bool operator<(CDoubleApprox db);
	bool operator>(CDoubleApprox db);
	bool operator>=(CDoubleApprox db);
	bool operator<=(CDoubleApprox db);

	// Operateurs d'opérations
	CDoubleApprox operator-();
	CDoubleApprox operator+();

	CDoubleApprox operator*(CDoubleApprox db) const;
	CDoubleApprox operator+(CDoubleApprox db) const;
	CDoubleApprox operator-(CDoubleApprox db) const;
	CDoubleApprox operator/(CDoubleApprox db) const;

	// Operateurs d'opérations avec affectations
	CDoubleApprox& operator*=(const CDoubleApprox db);
	CDoubleApprox& operator+=(const CDoubleApprox db);
	CDoubleApprox& operator-=(const CDoubleApprox db);
	CDoubleApprox& operator/=(const CDoubleApprox db);

};

inline CDoubleApprox operator ""_da(long double val) { return CDoubleApprox((double)val); }
inline CDoubleApprox operator ""_da(unsigned long long val) { return CDoubleApprox((double)val); }

// Operateurs d'égalités avec doubles
bool operator==(double db, CDoubleApprox cdb);
bool operator!=(double db, CDoubleApprox cdb);

// Operateurs de comparaisons avec doubles
bool operator<(double db, CDoubleApprox cdb);
bool operator>(double db, CDoubleApprox cdb);
bool operator>=(double db, CDoubleApprox cdb);
bool operator<=(double db, CDoubleApprox cdb);

// Operateurs d'opérations avec double
CDoubleApprox operator*(double db, CDoubleApprox cdb);
CDoubleApprox operator+(double db, CDoubleApprox cdb);
CDoubleApprox operator-(double db, CDoubleApprox cdb);
CDoubleApprox operator/(double db, CDoubleApprox cdb);

// Operateurs d'opérations avec affectations avec double
double& operator*=(double& db, const CDoubleApprox& cdb);
double& operator+=(double& db, const CDoubleApprox& cdb);
double& operator-=(double& db, const CDoubleApprox& cdb);
double& operator/=(double& db, const CDoubleApprox& cdb);