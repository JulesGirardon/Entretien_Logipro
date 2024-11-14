//Pour éviter les problèmes, ce fichier doit être enregistré au format UTF-8
//Grâce à ce commentaire qui contient des caractères accentués, c'est le cas.
#include <cmath>
#include "DoubleApprox.h"
#include <ostream>
const long double pi = 4 * std::atanl(1);

class CAngle {
private:
	CDoubleApprox m_daAngle;
public:

	// Constructeur de la classe CAngle
	CAngle() { m_daAngle = 0; };
	CAngle(double dAngleRad);

	// Getter
	CDoubleApprox GetAngle() const { return m_daAngle; }

	// Getter et setter d'angle en radiant
	double Rad() const;
	void SetRad(double dAngle);

	// Getter et setter d'angle en degrés
	double Deg() const;
	void SetDeg(double dAngle);

	// Getter et setter d'angle en gradiant
	double Grad() const;
	void SetGrad(double dAngle);
	
	// Opérateur d'égalités
	bool operator==(const CAngle& angle);
	bool operator!=(const CAngle& angle);

	// Opérateurs d'addition et soustraction
	CAngle operator+(const CAngle& angle) const;
	CAngle operator-(const CAngle& angle) const;
};

// Opérateur d'égalités avec des doubles
bool operator==(const double& db, const CAngle& angle);
bool operator!=(const double& db, const CAngle& angle);

// Opérateurs d'addition et soustraction avec des doubles
CAngle operator+(double db, const CAngle& angle);
CAngle operator-(double db, const CAngle& angle);

std::ostream& operator<<(std::ostream& out, const CAngle& angle);