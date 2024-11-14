#include "angle.h"
//Pour éviter les problèmes, ce fichier doit être enregistré au format UTF-8
//Grâce à ce commentaire qui contient des caractères accentués, c'est le cas.

CAngle::CAngle(double dAngleRad)
{
	m_daAngle = dAngleRad / pi;
	while (m_daAngle >= 1) m_daAngle -= 2;
	while (m_daAngle < -1) m_daAngle += 2;
}

double CAngle::Rad() const
{
	return m_daAngle.to_double() * pi;
}

void CAngle::SetRad(double dAngle)
{

	m_daAngle = dAngle / pi;
	while (m_daAngle >= 1) m_daAngle -= 2;
	while (m_daAngle < -1) m_daAngle += 2;
}

double CAngle::Deg() const
{
	return m_daAngle.to_double() * 180;
}

void CAngle::SetDeg(double dAngle)
{
	m_daAngle = dAngle / 180;
	while (m_daAngle >= 1) m_daAngle -= 2;
	while (m_daAngle < -1) m_daAngle += 2;
}

double CAngle::Grad() const
{
	return m_daAngle.to_double() * 200;
}

void CAngle::SetGrad(double dAngle)
{
	m_daAngle = dAngle / 200;
	while (m_daAngle >= 1) m_daAngle -= 2;
	while (m_daAngle < -1) m_daAngle += 2;
}

bool CAngle::operator==(const CAngle& angle)
{
	return m_daAngle == angle.m_daAngle;
}

bool CAngle::operator!=(const CAngle& angle)
{
	return m_daAngle != angle.m_daAngle;
}

CAngle CAngle::operator+(const CAngle& angle) const
{
	return CAngle(Rad() + angle.Rad());
}

CAngle CAngle::operator-(const CAngle& angle) const
{
	return CAngle(Rad() - angle.Rad());
}

bool operator==(const double& db, const CAngle& angle)
{
	return CAngle(db).GetAngle() == angle.GetAngle();
}

bool operator!=(const double& db, const CAngle& angle)
{
	return CAngle(db).GetAngle() != angle.GetAngle();
}

CAngle operator+(double db, const CAngle& angle)
{
	return CAngle(db) + angle;
}

CAngle operator-(double db, const CAngle& angle)
{
	return CAngle(db) - angle;
}

std::ostream& operator<<(std::ostream& out, const CAngle& angle) {
	out << angle.Rad() << " (" << angle.Deg() << "° / " << angle.Grad() << " grad)";
	return out;
}