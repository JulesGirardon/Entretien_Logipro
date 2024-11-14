#include "DoubleApprox.h"
#include <cmath>
//Pour éviter les problèmes, ce fichier doit être enregistré au format UTF-8
//Grâce à ce commentaire qui contient des caractères accentués, c'est le cas.

bool CDoubleApprox::operator==(CDoubleApprox db)
{
	return (fabs(m_dVal - db.m_dVal) <= 1e-10);
}

bool CDoubleApprox::operator!=(CDoubleApprox db)
{
	return (fabs(m_dVal - db.m_dVal) > 1e-10);
}

bool CDoubleApprox::operator<(CDoubleApprox db)
{
	return (m_dVal - db.m_dVal) < 0 && (m_dVal != db);
}

bool CDoubleApprox::operator>(CDoubleApprox db)
{ 
	return (m_dVal - db.m_dVal) > 0 && (m_dVal != db);
}

bool CDoubleApprox::operator>=(CDoubleApprox db)
{
	return m_dVal > db || (m_dVal == db);
}

bool CDoubleApprox::operator<=(CDoubleApprox db)
{
	return  m_dVal < db || (m_dVal == db);
}

CDoubleApprox CDoubleApprox::operator-()
{
	CDoubleApprox val(0);
	val.m_dVal = -m_dVal;
	return val;
}

CDoubleApprox CDoubleApprox::operator+()
{
	CDoubleApprox val(0);
	val.m_dVal = +m_dVal;
	return val;
}

CDoubleApprox CDoubleApprox::operator*(CDoubleApprox db) const
{
	CDoubleApprox val(0);
	val.m_dVal = m_dVal * db.m_dVal;
	return val;
}

CDoubleApprox CDoubleApprox::operator+(CDoubleApprox db) const
{
	CDoubleApprox val(0);
	val.m_dVal = m_dVal + db.m_dVal;
	return val;
}

CDoubleApprox CDoubleApprox::operator-(CDoubleApprox db) const
{
	CDoubleApprox val(0);
	val.m_dVal = m_dVal - db.m_dVal;
	return val;
}

CDoubleApprox CDoubleApprox::operator/(CDoubleApprox db) const
{
	CDoubleApprox val(0);
	val.m_dVal = m_dVal / db.m_dVal;
	return val;
}

CDoubleApprox& CDoubleApprox::operator*=(const CDoubleApprox db)
{
	m_dVal = m_dVal * db.m_dVal;
	return *this;
}

CDoubleApprox& CDoubleApprox::operator+=(const CDoubleApprox db)
{
	m_dVal = m_dVal + db.m_dVal;
	return *this;
}

CDoubleApprox& CDoubleApprox::operator-=(const CDoubleApprox db) 
{
	m_dVal = m_dVal - db.m_dVal;
	return *this;
}

CDoubleApprox& CDoubleApprox::operator/=(const CDoubleApprox db)
{
	m_dVal = m_dVal / db.m_dVal;
	return *this;
}




bool operator==(double db, CDoubleApprox cdb)
{
	return (fabs(db - cdb.to_double()) <= 1e-10);
} 

bool operator!=(double db, CDoubleApprox cdb)
{
	return !(db == cdb);
}

bool operator<(double db, CDoubleApprox cdb)
{
	return (db - cdb.to_double()) < 0 && db != cdb;
}

bool operator>(double db, CDoubleApprox cdb)
{
	return (db - cdb.to_double()) > 0;
}

bool operator>=(double db, CDoubleApprox cdb)
{
	return  db > cdb || db == cdb;
}

bool operator<=(double db, CDoubleApprox cdb)
{
	return  db < cdb || db == cdb;
}

CDoubleApprox operator*(double db, CDoubleApprox cdb)
{
	CDoubleApprox val(0);
	val.set_double(db * cdb.to_double());
	return val;
}

CDoubleApprox operator+(double db, CDoubleApprox cdb)
{
	CDoubleApprox val(0);
	val.set_double(db + cdb.to_double());
	return val;
}

CDoubleApprox operator-(double db, CDoubleApprox cdb)
{
	CDoubleApprox val(0);
	val.set_double(db - cdb.to_double());
	return val;
}

CDoubleApprox operator/(double db, CDoubleApprox cdb)
{
	CDoubleApprox val(0);
	val.set_double(db / cdb.to_double());
	return val;
}

double& operator*=(double& db, const CDoubleApprox& cdb)
{
	return db *= cdb.to_double();
}

double& operator+=(double& db, const CDoubleApprox& cdb)
{
	return db += cdb.to_double();
}

double& operator-=(double& db, const CDoubleApprox& cdb)
{
	db = db - cdb.to_double();
	return db;
}

double& operator/=(double& db, const CDoubleApprox& cdb)
{
	db = db / cdb.to_double();
	return db;
}
